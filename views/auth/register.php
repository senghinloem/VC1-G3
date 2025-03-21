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
    <title>Register</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: #f5f7fa;
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

        /* Logo placeholder */
        .logo-placeholder {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 40px;
            height: 40px;
            background: #00d4ff;
            border-radius: 5px;
        }

        /* Register card styling */
        .register-card {
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

        .register-card h2 {
            font-size: 24px;
            font-weight: 600;
            color: #1a252f;
            margin-bottom: 10px;
        }

        .register-card .subtitle {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 20px;
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

        /* Register button */
        .btn-register {
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

        .btn-register:hover {
            background: #1a252f;
            transform: scale(1.02);
        }

        /* Login link */
        .login-link {
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .login-link:hover {
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

        /* Success message styling */
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .illustration-col {
                display: none;
            }

            .register-card {
                max-width: 90%;
            }
        }
    </style>
</head>
<body>
    <!-- Logo placeholder -->
    <div class="logo-placeholder"></div>

    <div class="main-container">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left column: Illustration -->
                <div class="col-md-6 illustration-col">
                    <img src="views/assets/images/login.png" alt="Growth Illustration" class="illustration-img" style="max-width: 600px;">
                </div>

                <!-- Right column: Register form -->
                <div class="col-md-6">
                    <div class="register-card">
                        <h2>Register</h2>
                        <p class="subtitle">Manage all your inventory efficiently</p>

                        <!-- Success Alert -->
                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= $_SESSION['success']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php unset($_SESSION['success']); ?>
                        <?php endif; ?>

                        <!-- Error Alert -->
                        <?php if (isset($_SESSION['error_message'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= $_SESSION['error_message']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php unset($_SESSION['error_message']); ?>
                        <?php endif; ?>

                        <!-- Register form -->
                        <form action="/users/store" method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" class="form-control" placeholder="Enter your name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" class="form-control" placeholder="Enter your name" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone No. <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control" placeholder="minimum 8 characters" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                            </div>
                            <!-- Hidden role field (default to 'user') -->
                            <input type="hidden" name="role" value="user">
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="termsCheck" required>
                                <label class="form-check-label" for="termsCheck">I agree to all terms, privacy policies, and fees</label>
                            </div>
                            <button type="submit" class="btn btn-register">Sign Up</button>
                        </form>

                
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>