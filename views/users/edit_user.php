<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Profile - PNN Shop</title>
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

        .profile-container {
            display: flex;
            max-width: 900px;
            margin: 30px auto;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .profile-card {
            width: 35%;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 30px;
            text-align: center;
            border-right: 1px solid #e0e0e0;
            position: relative;
        }

        .profile-card .profile-image-container {
            position: relative;
            margin-bottom: 20px;
        }

        .profile-card img {
            width: 120px;
            height: 120px;
            border-radius: 15px;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .profile-card img:hover {
            transform: scale(1.05);
        }

        .profile-card .upload-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: #00c4cc;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease;
        }

        .profile-card .upload-btn:hover {
            background-color: #00a8b0;
        }

        .profile-card .upload-btn input {
            display: none;
        }

        .profile-card h3 {
            color: #333;
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .profile-card .role {
            color: #00c4cc;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }

        .form-container {
            width: 65%;
            padding: 30px;
        }

        .form-container h2 {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .form-container .form-control {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-container .form-control:focus {
            border-color: #00c4cc;
            box-shadow: 0 0 5px rgba(0, 196, 204, 0.3);
            outline: none;
        }

        .form-container label {
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-container .form-group {
            margin-bottom: 15px;
        }

        .form-container .btn-primary {
            background-color: #00c4cc;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .form-container .btn-primary:hover {
            background-color: #00a8b0;
            transform: translateY(-2px);
        }

        .form-container .btn-secondary {
            background-color: #ccc;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .form-container .btn-secondary:hover {
            background-color: #b0b0b0;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <!-- Profile Container with Single Form -->
    <div class="profile-container">
        <form action="/users/update/<?php echo isset($user['user_id']) ? htmlspecialchars($user['user_id'], ENT_QUOTES, 'UTF-8') : '0'; ?>" method="POST" enctype="multipart/form-data">
            <!-- Profile Card (Left Side) -->
            <div class="profile-card">
                <div class="form-group">
                    <label for="image" class="form-label">Profile Image</label>
                    <div class="profile-image-container">
                        <div class="profile-image-preview mb-2">
                            <?php if (!empty($user['image'])): ?>
                                <img src="/uploads/<?php echo htmlspecialchars($user['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Current Profile Image">
                            <?php else: ?>
                                <img src="/views/assets/img/user2-160x160.jpg" alt="Default Profile Image">
                            <?php endif; ?>
                        </div>
                        <label class="upload-btn">
                            <i class="fas fa-camera"></i>
                            <input type="file" id="image" name="image" accept="image/*">
                        </label>
                    </div>
                </div>
                <h3><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                <div class="role"><?php echo htmlspecialchars($user['role'], ENT_QUOTES, 'UTF-8'); ?></div>
            </div>

            <!-- Form (Right Side) -->
            <div class="form-container">
                <h2>Edit Profile</h2>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?php echo htmlspecialchars($user['password'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="form-group">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                        <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="/users" class="btn btn-secondary me-2"><i class="fas fa-arrow-left"></i> Cancel</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Profile</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Add image preview functionality
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.querySelector('.profile-image-preview img');
        const file = e.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
        }
    });
</script>
</body>
</html>