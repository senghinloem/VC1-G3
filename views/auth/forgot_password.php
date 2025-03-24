<?php


if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>
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

        .forgot-password-card {
            width: 100%;
            max-width: 480px;
            padding: 40px;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .forgot-password-card:hover {
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

        .btn-submit {
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

        .btn-submit:hover {
            transform: scale(1.02);
            background: linear-gradient(90deg, #5a7cff, #9b59b6);
        }

        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .debug-message {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            color: #495057;
            max-height: 200px;
            overflow-y: auto;
        }

        .login-link {
            font-size: 0.9rem;
            color: #7f8c8d;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .login-link:hover {
            color: #6e8efb;
        }

        @media (max-width: 768px) {
            .forgot-password-card {
                max-width: 100%;
                padding: 30px;
            }
            h2 {
                font-size: 1.8rem;
            }
            .btn-submit {
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
                    <div class="forgot-password-card">
                        <h2>Forgot Password</h2>
                        <div class="subtitle">Enter your email to reset your password</div>

                        <?php if (isset($_SESSION['error_message'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($_SESSION['error_message']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php unset($_SESSION['error_message']); ?>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($_SESSION['success']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php unset($_SESSION['success']); ?>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['debug_message'])): ?>
                            <div class="debug-message">
                                <strong>Debug Output:</strong><br>
                                <?= $_SESSION['debug_message']; ?>
                            </div>
                            <?php unset($_SESSION['debug_message']); ?>
                        <?php endif; ?>

                        <form action="/forgot-password" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                            </div>
                            <button type="submit" class="btn btn-submit">Submit</button>
                        </form>

                        <p class="mt-3 text-center">
                            <a href="/login" class="login-link">Back to Login</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>