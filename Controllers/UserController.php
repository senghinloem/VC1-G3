<?php
require_once "Models/UserModel.php";

class UserController extends BaseController
{
    private $user;

    public function __construct()
    {
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'secure' => true, // Requires HTTPS
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
        session_start();

        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) { // 30 minutes
            $this->logout();
        }
        $_SESSION['last_activity'] = time();

        try {
            $this->user = new UserModel();
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
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                    $_SESSION['error_message'] = 'Invalid CSRF token.';
                    header('Location: /register');
                    exit();
                }
                unset($_SESSION['csrf_token']);

                $first_name = filter_var(trim($_POST['first_name'] ?? ''), FILTER_SANITIZE_STRING);
                $last_name = filter_var(trim($_POST['last_name'] ?? ''), FILTER_SANITIZE_STRING);
                $email = strtolower(filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL));
                $phone = filter_var(trim($_POST['phone'] ?? ''), FILTER_SANITIZE_STRING);
                $password = trim($_POST['password'] ?? '');
                $role = filter_var($_POST['role'] ?? 'user', FILTER_SANITIZE_STRING);

                if (empty($first_name) || empty($last_name)) {
                    $_SESSION['error_message'] = 'First name and last name are required.';
                    header("Location: /register");
                    exit();
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['error_message'] = 'Invalid email address.';
                    header("Location: /register");
                    exit();
                }
                if (empty($phone)) {
                    $_SESSION['error_message'] = 'Phone number is required.';
                    header("Location: /register");
                    exit();
                }
                if (empty($password)) {
                    $_SESSION['error_message'] = 'Password is required.';
                    header("Location: /register");
                    exit();
                }

                if ($this->user->getUserByEmail($email)) {
                    $_SESSION['error_message'] = 'Email already registered.';
                    header("Location: /register");
                    exit();
                }

                $image = null;
                if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                    $image = $this->handleImageUpload($_FILES['image']);
                    if ($image === false) {
                        $_SESSION['error_message'] = 'Invalid image upload.';
                        header("Location: /register");
                        exit();
                    }
                }

                if ($this->user->addUser($first_name, $last_name, $email, $password, $role, $phone, $image)) {
                    $_SESSION['success'] = 'Registration successful! Please log in.';
                    header("Location: /login");
                } else {
                    $_SESSION['error_message'] = 'Failed to register user.';
                    header("Location: /register");
                }
                exit();
            } catch (Exception $e) {
                error_log("Registration error for $email: " . $e->getMessage());
                $_SESSION['error_message'] = $e->getMessage() ?: 'System error occurred.';
                header("Location: /register");
                exit();
            }
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
                if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                    $_SESSION['error_message'] = 'Invalid CSRF token.';
                    header('Location: /login');
                    exit();
                }
                unset($_SESSION['csrf_token']);
    
                $email = strtolower(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
                $password = trim($_POST['password'] ?? '');
    
                if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['error_message'] = 'Please enter a valid email address.';
                    header('Location: /login');
                    exit();
                }
    
                if (empty($password)) {
                    $_SESSION['error_message'] = 'Password is required.';
                    $_SESSION['email_value'] = $email;
                    header('Location: /login');
                    exit();
                }
    
                $user = $this->user->getUserByEmail($email);
                if (!$user) {
                    error_log("Login failed for $email - Email not found in database.");
                    $_SESSION['error_message'] = 'Invalid email or password.';
                    $_SESSION['email_value'] = $email;
                    header('Location: /login');
                    exit();
                }
    
                if (!password_verify($password, $user['password'])) {
                    error_log("Login failed for $email - Incorrect password.");
                    $_SESSION['error_message'] = 'Invalid email or password.';
                    $_SESSION['email_value'] = $email;
                    header('Location: /login');
                    exit();
                }
    
                if (isset($user['locked']) && $user['locked']) {
                    $_SESSION['error_message'] = 'Account is locked.';
                    header('Location: /login');
                    exit();
                }
    
                session_regenerate_id(true);
                error_log("Successful login for {$user['email']}");
    
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['phone'] = $user['phone'];
                $_SESSION['last_activity'] = time();
                $_SESSION['success'] = 'Login successful! Welcome, ' . $user['first_name'] . '!';
    
                $this->user->updateLastActivity($user['user_id']);
                header("Location: /dashboard");
                exit();
            } catch (Exception $e) {
                error_log("Login error for $email: " . $e->getMessage());
                $_SESSION['error_message'] = 'System error occurred: ' . $e->getMessage();
                header('Location: /login');
                exit();
            }
        } else {
            $_SESSION['error_message'] = 'Invalid access method.';
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

    public function resetLockout()
    {
        session_start();
        $ip = $_SERVER['REMOTE_ADDR'];
        unset($_SESSION["login_attempts_$ip"]);
        unset($_SESSION["lockout_$ip"]);
        $_SESSION['success'] = 'Login lockout reset. Try logging in again.';
        header('Location: /login');
        exit();
    }
}