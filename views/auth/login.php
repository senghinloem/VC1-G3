<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: /dashboard");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: #f5f7fa; /* Light background similar to the image */
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            margin: 0;
            height: 100vh;
        }

        /* Main container */
        .main-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Login card styling */
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            border-radius: 15px;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .login-card h2 {
            font-size: 24px;
            font-weight: 600;
            color: #1a252f;
            margin-bottom: 10px;
        }

        .login-card .subtitle {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 20px;
        }

        /* Google Sign-In button */
        .google-signin-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            background: #ffffff;
            font-size: 14px;
            color: #333;
            text-decoration: none;
            margin-bottom: 20px;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .google-signin-btn:hover {
            background: #f8f9fa;
            transform: scale(1.02);
        }

        .google-signin-btn img {
            width: 20px;
            margin-right: 10px;
        }

        /* Form field styling */
        .form-label {
            font-size: 14px;
            font-weight: 500;
            color: #1a252f;
        }

        .form-control {
            border-radius: 5px;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #e0e0e0;
            background: #f8f9fa;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.2);
        }

        .form-text {
            font-size: 12px;
            color: #6c757d;
        }

        .form-check-label {
            font-size: 14px;
            color: #6c757d;
        }

        /* Forgot password link */
        .forgot-password {
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        /* Login button */
        .btn-login {
            background: #2c3e50;
            border: none;
            border-radius: 5px;
            padding: 10px;
            font-size: 16px;
            font-weight: 500;
            width: 100%;
            color: #ffffff;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .btn-login:hover {
            background: #1a252f;
            transform: scale(1.02);
        }

        /* Register link */
        .register-link {
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .register-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        /* Illustration styling */
        .illustration-col {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .illustration-img {
            max-width: 100%;
            height: auto;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        /* Password toggle styling */
        .password-toggle {
            position: relative;
        }

        .password-toggle .form-control {
            padding-right: 40px; /* Space for the eye icon */
        }

        .password-toggle .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .password-toggle .toggle-password:hover {
            color: #007bff;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .illustration-col {
                display: none;
            }

            .login-card {
                max-width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left column: Login form -->
                <div class="col-md-6">
                    <div class="login-card">
                        <h2>Login</h2>
                        <!-- Display error message if login fails -->
                        <?php if (isset($_SESSION['error_message'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= $_SESSION['error_message']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php unset($_SESSION['error_message']); ?>
                        <?php endif; ?>


                        <!-- Login form -->
                        <form action="/users/authenticate" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                            </div>
                            <div class="mb-3 password-toggle">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" class="form-control" required>
                                <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                                <div class="form-text">minimum 8 characters</div>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                </div>
                                <a href="/forgot-password" class="forgot-password">Forgot password?</a>
                            </div>
                            <button type="submit" class="btn btn-login">Login</button>
                        </form>

                        <p class="mt-3 text-center">
                            Not registered yet? <a href="/register" class="register-link">Create a new account</a>
                        </p>
                    </div>
                </div>

                <!-- Right column: Illustration -->
                <div class="col-md-6 illustration-col">
                    <img src="views/assets/images/login.png" alt="Growth Illustration" class="illustration-img" style="max-width: 600px;">
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Show Password Toggle -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            // Toggle the type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle the eye icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>