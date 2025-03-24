<?php
require_once "BaseController.php";
require_once "Models/UserModel.php";
require_once "vendor/autoload.php"; // For PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class LoginRegisterController extends BaseController {
    private $user;

    public function __construct() {
        $this->user = new UserModel();
        session_start();
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            ini_set('session.cookie_secure', 1);
        }
        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
            $this->user->updateLastActivity($_SESSION['user_id']);
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->authenticate();
        } else {
            $this->view('auth/login');
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $first_name = $_POST['first_name'] ?? '';
            $last_name = $_POST['last_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $role = $_POST['role'] ?? 'user';
            $phone = $_POST['phone'] ?? '';

            if ($password !== $confirm_password) {
                $_SESSION['error_message'] = 'Passwords do not match';
                $this->redirect('/register');
            }

            if (strlen($password) < 8) {
                $_SESSION['error_message'] = 'Password must be at least 8 characters';
                $this->redirect('/register');
            }

            if ($this->user->addUser($first_name, $last_name, $email, $password, $role, $phone)) {
                $_SESSION['success'] = 'Registration successful! Please log in.';
                $this->redirect('/login');
            } else {
                $_SESSION['error_message'] = 'Registration failed. Email might already be in use.';
                $this->redirect('/register');
            }
        }
        $this->view('auth/register');
    }

    public function error() {
        $this->view('auth/error');
    }

    public function authenticate() {
        session_start();
        
        if (!isset($_SESSION['initialized'])) {
            session_regenerate_id(true);
            $_SESSION['initialized'] = true;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_message'] = 'Invalid request method';
            $this->redirect('/login');
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error_message'] = 'Invalid CSRF token';
            $this->redirect('/login');
        }

        try {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = trim($_POST['password'] ?? '');

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error_message'] = 'Invalid email format';
                $this->redirect('/login');
            }

            if (strlen($password) < 8) {
                $_SESSION['error_message'] = 'Password must be at least 8 characters';
                $_SESSION['email_value'] = $email;
                $this->redirect('/login');
            }

            if ($this->user->checkAccountLockout($email)) {
                $_SESSION['error_message'] = 'Account temporarily locked due to multiple failed attempts';
                $this->redirect('/login');
            }

            $user = $this->user->getUserByEmail($email);
            if (!$user) {
                $this->user->recordLoginAttempt($email);
                $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
                $_SESSION['last_attempt'] = time();
                $_SESSION['error_message'] = 'Invalid credentials';
                $_SESSION['email_value'] = $email;
                $this->redirect('/login');
            }

            if (!password_verify($password, $user['password'])) {
                $this->user->recordLoginAttempt($email);
                $this->user->updateFailedAttempts($user['user_id']);
                $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
                $_SESSION['last_attempt'] = time();
                $_SESSION['error_message'] = 'Invalid credentials';
                $_SESSION['email_value'] = $email;
                $this->redirect('/login');
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
            $this->redirect('/dashboard');
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            $_SESSION['error_message'] = 'An error occurred during login';
            $this->redirect('/login');
        }
    }

    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error_message'] = 'Invalid email format';
                $this->redirect('/forgot-password');
            }

            $token = $this->user->createPasswordResetToken($email);
            if ($token) {
                $resetLink = "http://localhost/reset-password?token=" . $token;
                
                $mail = new PHPMailer(true);
                try {
                    // Enable detailed debugging
                    $mail->SMTPDebug = 3; // 0 = off, 1 = client messages, 2 = client and server messages, 3 = more verbose
                    $mail->Debugoutput = function($str, $level) {
                        error_log("PHPMailer Debug [$level]: $str");
                        $_SESSION['debug_message'] .= "Debug [$level]: $str<br>";
                    };

                    // SendGrid SMTP configuration
                    $mail->isSMTP();
                    $mail->Host = 'smtp.sendgrid.net';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'apikey'; // SendGrid uses 'apikey' as the username
                    $mail->Password = 'SG.your-sendgrid-api-key-here'; // Replace with your SendGrid API key
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    // Ensure the sender email is verified in SendGrid
                    $mail->setFrom('your-verified-sender-email@example.com', 'VC1-G3 App'); // Replace with your verified sender email
                    $mail->addAddress($email);
                    $mail->isHTML(true);
                    $mail->Subject = 'Password Reset Request';
                    $mail->Body = "Click this link to reset your password: <a href='$resetLink'>$resetLink</a>";
                    
                    $mail->send();
                    $_SESSION['success'] = 'Password reset link has been sent to your email';
                } catch (Exception $e) {
                    $_SESSION['error_message'] = 'Failed to send reset email. Error: ' . $mail->ErrorInfo;
                    error_log("Mail error: " . $mail->ErrorInfo);
                }
            } else {
                $_SESSION['error_message'] = 'Email not found or error occurred';
            }
            $this->redirect('/forgot-password');
        }
        
        $this->view('auth/forgot_password');
    }

    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['token'] ?? '';
            $password = trim($_POST['password'] ?? '');
            $confirm_password = trim($_POST['confirm_password'] ?? '');

            if (strlen($password) < 8) {
                $_SESSION['error_message'] = 'Password must be at least 8 characters';
                $this->redirect("/reset-password?token=$token");
            }

            if ($password !== $confirm_password) {
                $_SESSION['error_message'] = 'Passwords do not match';
                $this->redirect("/reset-password?token=$token");
            }

            if ($this->user->resetPassword($token, $password)) {
                $_SESSION['success'] = 'Password has been reset successfully';
                $this->redirect('/login');
            } else {
                $_SESSION['error_message'] = 'Invalid or expired reset token';
                $this->redirect("/reset-password?token=$token");
            }
        }

        $token = $_GET['token'] ?? '';
        $this->view('auth/reset_password', ['token' => $token]);
    }
}
?>