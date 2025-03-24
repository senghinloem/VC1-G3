<?php
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #5a7cff, #9b59b6);
            font-family: 'Poppins', sans-serif;
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
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 480px;
            padding: 40px;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
        }

        h2 {
            font-size: 2rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
            text-align: center;
        }

        .subtitle {
            font-size: 1rem;
            color: #7f8c8d;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-label {
            font-weight: 500;
            color: #34495e;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #dcdcdc;
            padding: 12px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: #6e8efb;
            box-shadow: 0 0 8px rgba(110, 142, 251, 0.3);
            outline: none;
        }

        .btn-login {
            background: linear-gradient(90deg, #6e8efb, #a777e3);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 1.1rem;
            font-weight: 500;
            color: #fff;
            width: 100%;
            transition: transform 0.3s ease, background 0.3s ease;
        }

        .btn-login:hover {
            transform: scale(1.02);
            background: linear-gradient(90deg, #5a7cff, #9b59b6);
        }

        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .password-toggle {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #7f8c8d;
            transition: color 0.3s ease;
        }

        .toggle-password:hover {
            color: #34495e;
        }

        .register-link {
            font-size: 0.9rem;
            color: #7f8c8d;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .register-link:hover {
            color: #6e8efb;
        }

        @media (max-width: 768px) {
            .login-card {
                max-width: 100%;
                padding: 30px;
            }
            h2 {
                font-size: 1.8rem;
            }
            .btn-login {
                font-size: 1rem;
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="login-card">
                        <h2>Reset Password</h2>
                        <div class="subtitle">Enter your new password</div>

                        <?php if (isset($_SESSION['error_message'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($_SESSION['error_message']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php unset($_SESSION['error_message']); ?>
                        <?php endif; ?>

                        <form action="/reset-password" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                            <input type="hidden" name="token" value="<?= htmlspecialchars($token); ?>">
                            <div class="mb-3 password-toggle">
                                <label class="form-label">New Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter new password" required>
                                <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                            </div>
                            <div class="mb-3 password-toggle">
                                <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" name="confirm_password" id="confirmPassword" class="form-control" placeholder="Confirm new password" required>
                                <i class="fas fa-eye toggle-password" id="toggleConfirmPassword"></i>
                            </div>
                            <button type="submit" class="btn btn-login">Reset Password</button>
                        </form>

                        <p class="mt-3 text-center">
                            <a href="/login" class="register-link">Back to Login</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');
        const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
        const confirmPasswordInput = document.querySelector('#confirmPassword');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }

        if (toggleConfirmPassword && confirmPasswordInput) {
            toggleConfirmPassword.addEventListener('click', function () {
                const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPasswordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }
    </script>
</body>
</html>