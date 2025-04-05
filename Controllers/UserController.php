<?php
require_once "Models/UserModel.php";

class UserController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $this->userModel = new UserModel();
            
            if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
                $this->userModel->updateLastActivity($_SESSION['user_id']);
            }
        } catch (Exception $e) {
            error_log("Controller initialization failed: " . $e->getMessage());
            die("Controller initialization failed: " . $e->getMessage());
        }
    }

    // ... [keep all your existing methods unchanged until authenticate()]

    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_message'] = 'Invalid access';
            header('Location: /login');
            exit();
        }

        // CSRF token validation
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $_SESSION['error_message'] = 'Invalid CSRF token';
            header('Location: /login');
            exit();
        }

        try {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = trim($_POST['password'] ?? '');

            if (!$email) {
                $_SESSION['email_error'] = 'Please enter a valid email address';
                $_SESSION['error_message'] = 'Missing fields';
                header('Location: /login');
                exit();
            }

            if (empty($password)) {
                $_SESSION['password_error'] = 'Password is required';
                $_SESSION['error_message'] = 'Missing fields';
                $_SESSION['email_value'] = $email;
                header('Location: /login');
                exit();
            }

            $user = $this->userModel->login($email, $password);
            
            if (!$user) {
                $_SESSION['error_message'] = 'Invalid email or password';
                $_SESSION['email_value'] = $email;
                header('Location: /login');
                exit();
            }

            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['phone'] = $user['phone'];
            $_SESSION['image'] = $user['image'];
            $_SESSION['last_activity'] = $user['last_activity'];
            $_SESSION['success'] = 'Login successful! Welcome, ' . $user['first_name'] . '!';

            $this->userModel->updateLastActivity($user['user_id']);

            // Show redirect view with 2-second delay
            $this->view('users/redirect', [
                'message' => $_SESSION['success'],
                'redirectUrl' => '/dashboard',
                'delay' => 2
            ]);
            exit();

        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            $_SESSION['error_message'] = 'System error';
            header('Location: /login');
            exit();
        }
    }

    // ... [keep all your other existing methods]
}