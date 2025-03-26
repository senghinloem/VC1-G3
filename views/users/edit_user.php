<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .main-content {
            margin-left: 150px;
            padding: 70px 20px;
        }

        .profile-container {
            display: flex;
            max-width: 900px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin: 0 auto;
        }

        .profile-card {
            width: 40%;
            padding: 30px;
            text-align: center;
            border-right: 1px solid #e0e0e0;
        }

        .profile-card img {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            margin-top: 110px;
            border: 2px solid #e0e0e0;
        }

        .profile-card h3 {
            font-size: 20px;
            font-weight: 600;
            color: #00c4cc;
            margin-bottom: 5px;
        }

        .profile-card .username {
            color: #888;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .profile-card .form-group {
            margin-bottom: 15px;
        }

        .profile-card .form-control {
            font-size: 14px;
            padding: 8px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }

        .form-container {
            width: 60%;
            padding: 30px;
        }

        .form-container h2 {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 10px;
            font-size: 14px;
            width: 100%;
        }

        .form-control:focus {
            border-color: #00c4cc;
            box-shadow: 0 0 5px rgba(0, 196, 204, 0.3);
            outline: none;
        }

        label {
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
            display: block;
        }

        select.form-control {
            appearance: none;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="gray" viewBox="0 0 16 16"><path d="M8 12l-4-4h8l-4 4z"/></svg>') no-repeat right 10px center;
            background-size: 12px;
        }

        .row .col-md-6 {
            padding-right: 10px;
            padding-left: 10px;
        }

        .btn-primary {
            background-color: #00c4cc;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            color: #fff;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #00a8b0;
        }

        .btn-secondary {
            background-color: #e0e0e0;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            color: #333;
            transition: background-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #d0d0d0;
        }

        .btn i {
            margin-right: 5px;
        }

        .d-flex {
            gap: 10px;
        }

        .btn {
            cursor: pointer;
        }

        .d-none {
            display: none;
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
        }

        .image-preview-label {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <!-- Main Content -->
    <div class="main-content">
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="/users/update/<?php echo isset($user['user_id']) ? htmlspecialchars($user['user_id'], ENT_QUOTES, 'UTF-8') : '0'; ?>" 
              method="POST" 
              enctype="multipart/form-data" 
              id="editUserForm">
            <div class="profile-container">
                <div class="profile-card">
                    <img id="profile-img" 
                         src="<?php echo !empty($user['image']) ? '/uploads/' . htmlspecialchars($user['image'], ENT_QUOTES, 'UTF-8') : '/views/assets/img/user2-160x160.jpg'; ?>" 
                         alt="Profile">
                    <h3><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                    <p class="username">@<?php echo htmlspecialchars($user['username'] ?? 'username', ENT_QUOTES, 'UTF-8'); ?></p>
                    <div class="form-group">
                        <label for="image" class="btn btn-primary">
                            <span id="image-label">Change Profile Image</span>
                            <input type="file" 
                                   id="image" 
                                   name="image" 
                                   accept="image/*" 
                                   class="d-none">
                        </label>
                        <div id="image-preview" class="image-preview-label"></div>
                    </div>
                </div>

                <div class="form-container">
                    <h2>Edit Profile</h2>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="first_name" 
                                   name="first_name" 
                                   value="<?php echo htmlspecialchars($user['first_name'], ENT_QUOTES, 'UTF-8'); ?>" 
                                   required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="last_name" 
                                   name="last_name" 
                                   value="<?php echo htmlspecialchars($user['last_name'], ENT_QUOTES, 'UTF-8'); ?>" 
                                   required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" 
                               class="form-control" 
                               id="email" 
                               name="email" 
                               value="<?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?>" 
                               required>
                    </div>
                    <div class="form-group">
                        <label for="password">New Password (optional)</label>
                        <input type="password" 
                               class="form-control" 
                               id="password" 
                               name="password" 
                               placeholder="Enter new password to change (min 6 characters)">
                        <div id="password-error" class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                            <option value="editor" <?php echo $user['role'] === 'editor' ? 'selected' : ''; ?>>Editor</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" 
                               class="form-control" 
                               id="phone" 
                               name="phone" 
                               value="<?php echo htmlspecialchars($user['phone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <a href="/users" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Cancel</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Profile</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imageInput = document.getElementById('image');
            const profileImg = document.getElementById('profile-img');
            const imageLabel = document.getElementById('image-label');
            const imagePreview = document.getElementById('image-preview');
            const form = document.getElementById('editUserForm');
            const passwordInput = document.getElementById('password');
            const passwordError = document.getElementById('password-error');

            // Image preview and label update
            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profileImg.src = e.target.result;
                        imageLabel.textContent = 'Image Selected';
                        imagePreview.textContent = file.name;
                    };
                    reader.readAsDataURL(file);
                } else {
                    imageLabel.textContent = 'Change Profile Image';
                    imagePreview.textContent = '';
                }
            });

            // Client-side password validation
            form.addEventListener('submit', function(event) {
                const password = passwordInput.value.trim();
                if (password && password.length < 6) {
                    event.preventDefault();
                    passwordError.textContent = 'Password must be at least 6 characters long';
                } else {
                    passwordError.textContent = '';
                }
            });
        });
    </script>
</body>
</html>