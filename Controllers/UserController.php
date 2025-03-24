<?php
require_once "Models/UserModel.php";

class UserController extends BaseController
{
    private $user;

    public function __construct()
    {
        try {
            $this->user = new UserModel();
            session_start();
            if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
                $this->user->updateLastActivity($_SESSION['user_id']);
            }
        } catch (Exception $e) {
            die("Controller initialization failed: " . $e->getMessage());
        }
    }

    public function user()
    {
        $users = $this->user->getUsers();
        $totalUsers = $this->user->getTotalUsers();
        $activeUsers = $this->user->getActiveUsers();
        $inactiveUsers = $this->user->getInactiveUsers();
        
        $this->view('users/user', [
            'users' => $users,
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'inactiveUsers' => $inactiveUsers
        ]);
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
            
            if ($this->user->addUser(
                $_POST['first_name'] ?? '',
                $_POST['last_name'] ?? '',
                $_POST['email'] ?? '',
                $_POST['password'] ?? '',
                $_POST['role'] ?? '',
                $_POST['phone'] ?? '',
                $image
            )) {
                header("Location: /users");
            } else {
                header("Location: /users/create?error=Failed to add user");
            }
            exit();
        }
    }

    public function edit($user_id)
    {
        $user = $this->user->getUserById($user_id);
        if (!$user) {
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
            
            if ($this->user->updateUser(
                $user_id,
                $_POST['first_name'] ?? '',
                $_POST['last_name'] ?? '',
                $_POST['email'] ?? '',
                $_POST['password'] ?? '',
                $_POST['role'] ?? '',
                $_POST['phone'] ?? '',
                $image
            )) {
                header("Location: /users");
            } else {
                header("Location: /users/edit/$user_id?error=Failed to update user");
            }
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
        if ($this->user->deleteUser($user_id)) {
            header("Location: /users");
        } else {
            header("Location: /users?error=Failed to delete user");
        }
        exit();
    }

    public function search()
    {
        $query = isset($_GET['search']) ? $_GET['search'] : '';
        $users = $this->user->searchUsers($query);
        $this->view('users/user', [
            'users' => $users,
            'searchQuery' => $query,
            'totalUsers' => $this->user->getTotalUsers(),
            'activeUsers' => $this->user->getActiveUsers(),
            'inactiveUsers' => $this->user->getInactiveUsers()
        ]);
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
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
                $password = trim($_POST['password'] ?? '');

                if (!$email) {
                    $_SESSION['email_error'] = 'Please enter a valid email address';
                    $_SESSION['error_message'] = 'missing_fields';
                    header('Location: /login');
                    exit();
                }

                if (empty($password)) {
                    $_SESSION['password_error'] = 'Password is required';
                    $_SESSION['error_message'] = 'missing_fields';
                    $_SESSION['email_value'] = $email;
                    header('Location: /login');
                    exit();
                }

                $user = $this->user->getUserByEmail($email);
                if (!$user) {
                    $_SESSION['error_message'] = 'You cannot login please check your email.';
                    $_SESSION['email_value'] = $email;
                    header('Location: /login');
                    exit();
                }

                if (!password_verify($password, $user['password'])) {
                    $_SESSION['error_message'] = 'You cannot login please check your password.';
                    $_SESSION['email_value'] = $email;
                    header('Location: /login');
                    exit();
                }

                if (isset($user['locked']) && $user['locked']) {
                    $_SESSION['error_message'] = 'account_locked';
                    header('Location: /login');
                    exit();
                }

                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['phone'] = $user['phone'];
                $_SESSION['success'] = 'Login successful! Welcome, ' . $user['first_name'] . '!';
                
                $this->user->updateLastActivity($user['user_id']);

                header("Location: /dashboard");
                exit();

            } catch (Exception $e) {
                error_log("Login error: " . $e->getMessage());
                $_SESSION['error_message'] = 'system_error';
                header('Location: /login');
                exit();
            }
        } else {
            $_SESSION['error_message'] = 'invalid_access';
            header('Location: /login');
            exit();
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        $_SESSION['success'] = 'Logged out successfully';
        $this->redirect("/");
    }
}
?>