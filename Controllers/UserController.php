<?php
require_once "Models/UserModel.php";
require_once "vendor/autoload.php"; // For PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserController extends BaseController {
    private $user;

    public function __construct() {
        try {
            $this->user = new UserModel();
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                ini_set('session.cookie_secure', 1);
            }
            if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
                $this->user->updateLastActivity($_SESSION['user_id']);
            }
        } catch (Exception $e) {
            die("Controller initialization failed: " . $e->getMessage());
        }
    }

    public function authenticate() {
        session_start();
        
        if (!isset($_SESSION['initialized'])) {
            session_regenerate_id(true);
            $_SESSION['initialized'] = true;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_message'] = 'Invalid request method';
            header('Location: /login');
            exit();
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error_message'] = 'Invalid CSRF token';
            header('Location: /login');
            exit();
        }

        try {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = trim($_POST['password'] ?? '');

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error_message'] = 'Invalid email format';
                header('Location: /login');
                exit();
            }

            if (strlen($password) < 8) {
                $_SESSION['error_message'] = 'Password must be at least 8 characters';
                $_SESSION['email_value'] = $email;
                header('Location: /login');
                exit();
            }

            if ($this->user->checkAccountLockout($email)) {
                $_SESSION['error_message'] = 'Account temporarily locked due to multiple failed attempts';
                header('Location: /login');
                exit();
            }

            $user = $this->user->getUserByEmail($email);
            if (!$user) {
                $this->user->recordLoginAttempt($email);
                $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
                $_SESSION['last_attempt'] = time();
                $_SESSION['error_message'] = 'Invalid credentials';
                $_SESSION['email_value'] = $email;
                header('Location: /login');
                exit();
            }

            if (!password_verify($password, $user['password'])) {
                $this->user->recordLoginAttempt($email);
                $this->user->updateFailedAttempts($user['user_id']);
                $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
                $_SESSION['last_attempt'] = time();
                $_SESSION['error_message'] = 'Invalid credentials';
                $_SESSION['email_value'] = $email;
                header('Location: /login');
                exit();
            }

            $this->user->updateFailedAttempts($user['user_id'], false);
            $_SESSION['login_attempts'] = 0;

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['first_name'] = htmlspecialchars($user['first_name']);
            $_SESSION['last_name'] = htmlspecialchars($user['last_name']);
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['phone'] = htmlspecialchars($user['phone']);
            $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            $_SESSION['last_activity'] = time();
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            
            $this->user->updateLastActivity($user['user_id']);
            $_SESSION['success'] = 'Login successful! Welcome, ' . $user['first_name'] . '!';
            header("Location: /dashboard");
            exit();
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            $_SESSION['error_message'] = 'An error occurred during login';
            header('Location: /login');
            exit();
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = array();
        session_regenerate_id(true);
        session_destroy();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 3600,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_start();
        $_SESSION['success'] = 'Logged out successfully';
        header("Location: /login");
        exit();
    }

    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error_message'] = 'Invalid email format';
                header('Location: /forgot-password');
                exit();
            }

            $token = $this->user->createPasswordResetToken($email);
            if ($token) {
                $resetLink = "http://localhost/reset-password?token=" . $token;
                
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'your-email@gmail.com';
                    $mail->Password = 'your-app-password';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    $mail->setFrom('your-email@gmail.com', 'Your App');
                    $mail->addAddress($email);
                    $mail->isHTML(true);
                    $mail->Subject = 'Password Reset Request';
                    $mail->Body = "Click this link to reset your password: <a href='$resetLink'>$resetLink</a>";
                    
                    $mail->send();
                    $_SESSION['success'] = 'Password reset link has been sent to your email';
                } catch (Exception $e) {
                    $_SESSION['error_message'] = 'Failed to send reset email';
                    error_log("Mail error: " . $mail->ErrorInfo);
                }
            } else {
                $_SESSION['error_message'] = 'Email not found or error occurred';
            }
            header('Location: /forgot-password');
            exit();
        }
        
        $this->view('forgot_password');
    }

    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['token'] ?? '';
            $password = trim($_POST['password'] ?? '');
            $confirm_password = trim($_POST['confirm_password'] ?? '');

            if (strlen($password) < 8) {
                $_SESSION['error_message'] = 'Password must be at least 8 characters';
                header("Location: /reset-password?token=$token");
                exit();
            }

            if ($password !== $confirm_password) {
                $_SESSION['error_message'] = 'Passwords do not match';
                header("Location: /reset-password?token=$token");
                exit();
            }

            if ($this->user->resetPassword($token, $password)) {
                $_SESSION['success'] = 'Password has been reset successfully';
                header('Location: /login');
            } else {
                $_SESSION['error_message'] = 'Invalid or expired reset token';
                header("Location: /reset-password?token=$token");
            }
            exit();
        }

        $token = $_GET['token'] ?? '';
        $this->view('reset_password', ['token' => $token]);
    }

    public function user() {
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

    public function create() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is logged in and has admin privileges
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            $_SESSION['error_message'] = 'Unauthorized access. Admin privileges required.';
            header("Location: /login");
            exit();
        }

        // Generate CSRF token for the form
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        // Pass any error/success messages from previous actions
        $data = [
            'csrf_token' => $_SESSION['csrf_token'],
            'error' => $_GET['error'] ?? null
        ];

        // Render the create user view
        $this->view('users/create_user', $data);
    }

    public function store() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_message'] = 'Invalid request method';
            header('Location: /users/create');
            exit();
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error_message'] = 'Invalid CSRF token';
            header('Location: /users/create');
            exit();
        }

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
            $_SESSION['success'] = 'User created successfully';
            header("Location: /users");
        } else {
            header("Location: /users/create?error=Failed to add user");
        }
        exit();
    }

    public function edit($user_id) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is logged in and has admin privileges
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
            $_SESSION['error_message'] = 'Unauthorized access. Admin privileges required.';
            header("Location: /login");
            exit();
        }

        // Fetch the user by ID
        $user = $this->user->getUserById($user_id);
        if (!$user) {
            $_SESSION['error_message'] = 'User not found';
            header("Location: /users?error=User not found");
            exit();
        }

        // Generate CSRF token for the form
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        // Prepare data for the view
        $data = [
            'user' => $user,
            'csrf_token' => $_SESSION['csrf_token'],
            'error' => $_GET['error'] ?? null
        ];

        // Render the edit user view
        $this->view('users/edit_user', $data);
    }

    public function update($user_id) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_message'] = 'Invalid request method';
            header("Location: /users/edit/$user_id");
            exit();
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error_message'] = 'Invalid CSRF token';
            header("Location: /users/edit/$user_id");
            exit();
        }

        $image = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $image = $this->handleImageUpload($_FILES['image']);
            if ($image === false) {
                header("Location: /users/edit/$user_id?error=Invalid image");
                exit();
            }
        }
        
        $password = $_POST['password'] ?? '';
        if (!empty($password)) {
            $password = password_hash($password, PASSWORD_ARGON2ID, ['cost' => 12]);
        } else {
            $user = $this->user->getUserById($user_id);
            $password = $user['password'];
        }
        
        if ($this->user->updateUser(
            $user_id,
            $_POST['first_name'] ?? '',
            $_POST['last_name'] ?? '',
            $_POST['email'] ?? '',
            $password,
            $_POST['role'] ?? '',
            $_POST['phone'] ?? '',
            $image
        )) {
            $_SESSION['success'] = 'User updated successfully';
            header("Location: /users");
        } else {
            header("Location: /users/edit/$user_id?error=Failed to update user");
        }
        exit();
    }

    public function destroy($user_id) {
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

    public function search() {
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

    private function handleImageUpload($file) {
        if ($file['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }
        
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024;
        
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
}
?>