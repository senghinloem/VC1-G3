<?php

// Security headers
header("Content-Security-Policy: default-src 'self'");
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: /dashboard");
    exit();
}

// CSRF token generation
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Rate limiting for registration attempts (simple session-based example)
define('MAX_REGISTER_ATTEMPTS', 5);
define('LOCKOUT_DURATION', 15 * 60); // 15 minutes

function checkRegisterAttempts() {
    if (!isset($_SESSION['register_attempts'])) {
        $_SESSION['register_attempts'] = 0;
        $_SESSION['last_register_attempt'] = time();
    }
    
    if ($_SESSION['register_attempts'] >= MAX_REGISTER_ATTEMPTS) {
        if (time() - $_SESSION['last_register_attempt'] < LOCKOUT_DURATION) {
            $_SESSION['error_message'] = 'Too many registration attempts. Please try again later.';
            header('Location: /register');
            exit();
        } else {
            // Reset attempts after lockout period
            $_SESSION['register_attempts'] = 0;
        }
    }
}
checkRegisterAttempts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Your existing styles remain unchanged */
        body {
            background: linear-gradient(135deg, #5a7cff, #9b59b6);
            font-family: 'Inter', sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1), transparent);
            animation: pulse 15s infinite;
            z-index: 0;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 0.2; }
            100% { transform: scale(1); opacity: 0.5; }
        }

        .main-container {
            z-index: 1;
            width: 100%;
            padding: 15px;
        }

        .register-card {
            width: 100%;
            max-width: 500px;
            padding: 25px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .register-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        h2 {
            font-size: 1.6rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
            text-align: center;
        }

        .subtitle {
            font-size: 0.9rem;
            color: #7f8c8d;
            text-align: center;
            margin-bottom: 15px;
        }

        .form-label {
            font-weight: 500;
            color: #34495e;
            font-size: 0.9rem;
            margin-bottom: 3px;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #dcdcdc;
            padding: 8px;
            font-size: 0.9rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            height: 38px;
        }

        .form-control:focus {
            border-color: #6e8efb;
            box-shadow: 0 0 6px rgba(110, 142, 251, 0.3);
            outline: none;
        }

        .btn-register {
            background: linear-gradient(90deg, #6e8efb, #a777e3);
            border: none;
            border-radius: 10px;
            padding: 10px;
            font-size: 1rem;
            font-weight: 500;
            color: #fff;
            width: 100%;
            transition: transform 0.3s ease, background 0.3s ease;
        }

        .btn-register:hover {
            transform: scale(1.02);
            background: linear-gradient(90deg, #5a7cff, #9b59b6);
        }

        .alert {
            border-radius: 8px;
            margin-bottom: 10px;
            font-size: 0.8rem;
        }

        .password-toggle {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #7f8c8d;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .toggle-password:hover {
            color: #34495e;
        }

        .form-check-label, .login-link {
            font-size: 0.85rem;
            color: #7f8c8d;
        }

        .login-link {
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .login-link:hover {
            color: #6e8efb;
        }

        .illustration-col {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .illustration-img {
            max-width: 100%;
            height: auto;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @media (max-width: 768px) {
            .register-card {
                max-width: 100%;
                padding: 20px;
            }
            .illustration-col {
                display: none;
            }
            h2 {
                font-size: 1.4rem;
            }
            .btn-register {
                font-size: 0.9rem;
                padding: 8px;
            }
            .row .col-md-6 {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 illustration-col">
                    <img src="views/assets/images/login.png" alt="Growth Illustration" class="illustration-img">
                </div>

                <div class="col-md-6">
                    <div class="register-card">
                        <h2>Create Account</h2>
                        <p class="subtitle">Manage all your inventory efficiently</p>

                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($_SESSION['success']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php unset($_SESSION['success']); ?>
                        <?php elseif (isset($_SESSION['error_message'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($_SESSION['error_message']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php unset($_SESSION['error_message']); ?>
                        <?php endif; ?>

                        <form id="registerForm" action="/users/store" method="POST" novalidate autocomplete="off">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" class="form-control" 
                                           value="<?= htmlspecialchars($_SESSION['first_name'] ?? '') ?>" 
                                           placeholder="Enter your first name" 
                                           pattern="[A-Za-z\s]{2,50}" 
                                           required 
                                           autocomplete="off">
                                    <?php unset($_SESSION['first_name']); ?>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" class="form-control" 
                                           value="<?= htmlspecialchars($_SESSION['last_name'] ?? '') ?>" 
                                           placeholder="Enter your last name" 
                                           pattern="[A-Za-z\s]{2,50}" 
                                           required 
                                           autocomplete="off">
                                    <?php unset($_SESSION['last_name']); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" 
                                           value="<?= htmlspecialchars($_SESSION['email'] ?? '') ?>" 
                                           placeholder="Enter your email" 
                                           required 
                                           autocomplete="off">
                                    <?php unset($_SESSION['email']); ?>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="form-label">Phone No. <span class="text-danger">*</span></label>
                                    <input type="tel" name="phone" class="form-control" 
                                           value="<?= htmlspecialchars($_SESSION['phone'] ?? '') ?>" 
                                           placeholder="e.g., 1234567890" 
                                           pattern="[0-9]{10}" 
                                           required 
                                           autocomplete="off">
                                    <?php unset($_SESSION['phone']); ?>
                                </div>
                            </div>
                            <div class="mb-2 password-toggle">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" class="form-control" 
                                       placeholder="Enter your password" 
                                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                                       title="Must contain at least one number, one uppercase and lowercase letter, and at least 8 characters" 
                                       required 
                                       autocomplete="new-password">
                                <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                                <div class="form-text">Min 8 chars, including 1 number, 1 uppercase, 1 lowercase</div>
                            </div>
                            <input type="hidden" name="role" value="user">
                            <div class="mb-2 form-check">
                                <input type="checkbox" class="form-check-input" id="termsCheck" required>
                                <label class="form-check-label" for="termsCheck">I agree to all terms, privacy policies, and fees</label>
                            </div>
                            <button type="submit" class="btn btn-register">Sign Up</button>
                        </form>

                        <p class="mt-2 text-center">
                            Already have an account? <a href="/login" class="login-link">Sign in</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('registerForm');
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });

        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');
        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }
    </script>
</body>
</html>