<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - PNN Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh; /* Full viewport height */
            overflow: hidden; /* Prevent scrolling */
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh; /* Full screen height */
            width: 100vw; /* Full screen width */
        }

        .main-content {
            flex-grow: 1; /* Take up all available space */
            padding: 0; /* Remove padding to maximize space */
        }

        .custom-bg {
            background: linear-gradient(to right, #e2e8f0, #e5e7eb);
            height: 100vh; /* Full viewport height */
            width: 100vw; /* Full viewport width */
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .content-wrapper {
            text-align: center;
            padding: 20px;
        }

        .custom-btn {
            background-color: #fff;
            color: #333;
            border: none;
        }

        .custom-btn:hover {
            background-color: #f3e8ff !important;
            transition: background-color 0.3s ease-in-out;
        }

        @media (prefers-color-scheme: dark) {
            .custom-bg {
                background: linear-gradient(to right, #1f2937, #111827);
                color: white !important;
            }

            .custom-btn {
                background-color: #374151 !important;
                color: white !important;
            }

            .custom-btn:hover {
                background-color: #4b5563 !important;
            }
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <!-- Main Content -->
    <div class="main-content">
        <!-- 404 Content -->
        <div class="custom-bg text-dark">
            <div class="content-wrapper">
                <h1 class="display-1 fw-bold">404</h1>
                <p class="fs-2 fw-medium mt-4">Oops! Page not found</p>
                <p class="mt-4 mb-5">The page you're looking for doesn't exist or has been moved.</p>
                <button onclick="history.back()" class="btn fw-semibold rounded-pill px-4 py-2 custom-btn">
                    Back
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>