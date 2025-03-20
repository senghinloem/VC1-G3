<?php
require_once "Models/UserModel.php";

class UserController extends BaseController
{
    private $user;

    public function __construct()
    {
        $this->user = new UserModel();
    }

    public function user()
    {
        $users = $this->user->getUsers();
        $this->view('users/user', ['users' => $users]);
    }

    public function create()
    {
        $this->view('users/create_user');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                $image = $this->handleImageUpload($_FILES['image']);
                if ($image === false) {
                    header("Location: /users/create?error=Invalid image");
                    exit();
                }
            }
            
            $this->user->addUser(
                $_POST['first_name'],
                $_POST['last_name'],
                $_POST['email'],
                $_POST['password'],
                $_POST['role'],
                $_POST['phone'],
                $image
            );
            header("Location: /users");
            exit();
        }
    }

    public function edit($user_id)
    {
        $user = $this->user->getUserById($user_id);
        if (!$user) {
            // Handle case where user is not found
            header("Location: /users?error=User not found");
            exit();
        }
        $this->view('users/edit_user', ['user' => $user]);
    }

    public function update($user_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                $image = $this->handleImageUpload($_FILES['image']);
                if ($image === false) {
                    header("Location: /users/edit/$user_id?error=Invalid image");
                    exit();
                }
            }
            
            $this->user->updateUser(
                $user_id,
                $_POST['first_name'],
                $_POST['last_name'],
                $_POST['email'],
                $_POST['password'],
                $_POST['role'],
                $_POST['phone'],
                $image
            );
            header("Location: /users");
            exit();
        }
    }

    public function destroy($user_id)
    {
        $user = $this->user->getUserById($user_id);
        if ($user && $user['image']) {
            $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $user['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $this->user->deleteUser($user_id);
        header("Location: /users");
        exit();
    }

    public function search()
    {
        $query = isset($_GET['search']) ? $_GET['search'] : '';
        $users = $this->user->searchUsers($query);
        $this->view('users/user', ['users' => $users, 'searchQuery' => $query]);
    }

    private function handleImageUpload($file)
    {
        if ($file['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }
        
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        
        if (!in_array($file['type'], $allowedTypes) || $file['size'] > $maxSize) {
            return false;
        }
        
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $filename = uniqid() . '_' . basename($file['name']);
        $destination = $uploadDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $filename;
        }
        return false;
    }

    public function authenticate()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->user->getUserByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];
            header("Location: /dashboard");
            exit();
        } else {
            header("Location: /login?error=Invalid credentials");
            exit();
        }
    }
}

}