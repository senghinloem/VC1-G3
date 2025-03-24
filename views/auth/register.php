<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: /dashboard");
    exit();
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
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

        /* Background Animation */
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
            padding: 15px; /* Reduced padding */
        }

        .register-card {
            width: 100%;
            max-width: 500px; /* Reduced max-width */
            padding: 25px; /* Reduced padding */
            border-radius: 20px; /* Slightly smaller border-radius */
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15); /* Reduced shadow */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .register-card:hover {
            transform: translateY(-3px); /* Reduced hover lift */
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        h2 {
            font-size: 1.6rem; /* Reduced font size */
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px; /* Reduced margin */
            text-align: center;
        }

        .subtitle {
            font-size: 0.9rem; /* Reduced font size */
            color: #7f8c8d;
            text-align: center;
            margin-bottom: 15px; /* Reduced margin */
        }

        .form-label {
            font-weight: 500;
            color: #34495e;
            font-size: 0.9rem; /* Reduced font size */
            margin-bottom: 3px; /* Reduced margin */
        }

        .form-control {
            border-radius: 8px; /* Slightly smaller border-radius */
            border: 1px solid #dcdcdc;
            padding: 8px; /* Reduced padding */
            font-size: 0.9rem; /* Reduced font size */
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            height: 38px; /* Reduced height */
        }

        .form-control:focus {
            border-color: #6e8efb;
            box-shadow: 0 0 6px rgba(110, 142, 251, 0.3); /* Reduced shadow */
            outline: none;
        }

        .btn-register {
            background: linear-gradient(90deg, #6e8efb, #a777e3);
            border: none;
            border-radius: 10px; /* Slightly smaller border-radius */
            padding: 10px; /* Reduced padding */
            font-size: 1rem; /* Reduced font size */
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
            border-radius: 8px; /* Slightly smaller border-radius */
            margin-bottom: 10px; /* Reduced margin */
            font-size: 0.8rem; /* Reduced font size */
        }

        .password-toggle {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 10px; /* Adjusted for smaller input */
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #7f8c8d;
            font-size: 0.9rem; /* Reduced icon size */
            transition: color 0.3s ease;
        }

        .toggle-password:hover {
            color: #34495e;
        }

        .form-check-label, .login-link {
            font-size: 0.85rem; /* Reduced font size */
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
            50% { transform: translateY(-10px); } /* Reduced float distance */
        }

        @media (max-width: 768px) {
            .register-card {
                max-width: 100%;
                padding: 20px; /* Further reduced padding for mobile */
            }
            .illustration-col {
                display: none;
            }
            h2 {
                font-size: 1.4rem; /* Further reduced font size for mobile */
            }
            .btn-register {
                font-size: 0.9rem; /* Reduced font size for mobile */
                padding: 8px; /* Reduced padding for mobile */
            }
            .row .col-md-6 {
                width: 100%; /* Stack fields vertically on small screens */
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

                        <form id="registerForm" action="/users/store" method="POST" novalidate>
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                            <div class="row">
                                <div class="col-md-6 mb-2"> <!-- Reduced margin (mb-3 to mb-2) -->
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" class="form-control" placeholder="Enter your first name" required>
                                </div>
                                <div class="col-md-6 mb-2"> <!-- Reduced margin -->
                                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" class="form-control" placeholder="Enter your last name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2"> <!-- Reduced margin -->
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                                </div>
                                <div class="col-md-6 mb-2"> <!-- Reduced margin -->
                                    <label class="form-label">Phone No. <span class="text-danger">*</span></label>
                                    <input type="tel" name="phone" class="form-control" placeholder="e.g., 1234567890" required>
                                </div>
                            </div>
                            <div class="mb-2 password-toggle"> <!-- Reduced margin -->
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                                <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                                <div class="form-text">Enter your password</div>
                            </div>
                            <input type="hidden" name="role" value="user">
                            <div class="mb-2 form-check"> <!-- Reduced margin (mb-4 to mb-2) -->
                                <input type="checkbox" class="form-check-input" id="termsCheck" required>
                                <label class="form-check-label" for="termsCheck">I agree to all terms, privacy policies, and fees</label>
                            </div>
                            <button type="submit" class="btn btn-register">Sign Up</button>
                        </form>

                        <p class="mt-2 text-center"> <!-- Reduced margin (mt-3 to mt-2) -->
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