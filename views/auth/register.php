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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .register-container {
            width: 500px;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background: #fff;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">
<div class="register-container">
    <h2 class="text-center">Register</h2>

    <!-- Success Alert -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success']); // Clear message after showing ?>
    <?php endif; ?>

    <form action="/users/store" method="POST">
        <div class="mb-2">
            <label class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control form-control-sm" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control form-control-sm" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control form-control-sm" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control form-control-sm" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Role</label>
            <select name="role" class="form-control form-control-sm">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div class="mb-2">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control form-control-sm" required>
        </div>
        <button type="submit" class="btn btn-primary w-100 btn-sm">Register</button>
    </form>
    <p class="mt-2 text-center">Already have an account? <a href="/login">Login</a></p>
</div>

<!-- Bootstrap JS for the alert close button -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
