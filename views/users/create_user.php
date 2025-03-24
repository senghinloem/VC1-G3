<?php
// session_start();
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
    <title>Create User - PNN Shop</title>
    <!-- Bootstrap CSS for layout and styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            position: fixed;
            height: 100%;
        }

        .sidebar .logo {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 30px;
        }

        .sidebar .nav-item {
            margin-bottom: 15px;
        }

        .sidebar .nav-item a {
            color: #b0b7c0;
            text-decoration: none;
            font-size: 16px;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-item a i {
            margin-right: 10px;
        }

        .sidebar .nav-item a:hover {
            color: white;
        }

        .sidebar .nav-item.active a {
            color: white;
            font-weight: 600;
        }

        .sidebar .nav-item.logout a {
            color: #e74c3c;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: 100%;
        }

        .topbar {
            background-color: #fff;
            padding: 10px 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .topbar .user-info {
            display: flex;
            align-items: center;
        }

        .topbar .user-info img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .create-user-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .create-user-container h5 {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
            position: relative;
        }

        .create-user-container h5::after {
            content: '';
            position: absolute;
            width: 50px;
            height: 3px;
            background: #00c4cc;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
        }

        .create-user-container .form-control {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .create-user-container .form-control:focus {
            border-color: #00c4cc;
            box-shadow: 0 0 5px rgba(0, 196, 204, 0.3);
            outline: none;
        }

        .create-user-container .form-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .create-user-container .form-select:focus {
            border-color: #00c4cc;
            box-shadow: 0 0 5px rgba(0, 196, 204, 0.3);
            outline: none;
        }

        .create-user-container label {
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .create-user-container .form-group {
            margin-bottom: 20px;
        }

        .create-user-container .btn-primary {
            background: linear-gradient(45deg, #00c4cc, #0088cc);
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }

        .create-user-container .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 196, 204, 0.4);
        }

        .create-user-container .btn-secondary {
            background-color: #ccc;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }

        .create-user-container .btn-secondary:hover {
            background-color: #b0b0b0;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<div class="dashboard-container">
        <!-- Create User Form -->
        <div class="create-user-container">
            <h5><i class="fas fa-user-plus me-2"></i>Create New User</h5>
            <form action="/users/store" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="" disabled selected>Select role</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <option value="editor">Editor</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="tel" class="form-control" id="phone" name="phone">
                </div>
                <div class="form-group">
                    <label for="image" class="form-label">Profile Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <a href="/users" class="btn btn-secondary me-2"><i class="fas fa-arrow-left"></i> Cancel</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>