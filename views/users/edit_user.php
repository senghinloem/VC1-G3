<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
    <title>Edit User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/views/assets/css/edit_user.css">
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
                    <?php
                    // Define the default image path
                    $defaultImage = '/views/assets/img/user2-160x160.jpg';
                    // Check if user image exists and is valid
                    $userImage = !empty($user['image']) 
                        ? '/uploads/' . htmlspecialchars($user['image'], ENT_QUOTES, 'UTF-8') 
                        : $defaultImage;

                    // Construct absolute path to check if the image exists
                    $imagePath = $_SERVER['DOCUMENT_ROOT'] . $userImage;

                    // If the image doesn't exist or isn't readable, fall back to a placeholder or default
                    if (!file_exists($imagePath) || !is_readable($imagePath)) {
                        $userImage = $defaultImage; // Try the default image again
                        $defaultImagePath = $_SERVER['DOCUMENT_ROOT'] . $defaultImage;

                        // If even the default image is missing, use a fallback placeholder
                        if (!file_exists($defaultImagePath) || !is_readable($defaultImagePath)) {
                            $userImage = '/views/assets/img/placeholder-user.jpg'; // Ensure this placeholder exists
                            $placeholderPath = $_SERVER['DOCUMENT_ROOT'] . $userImage;

                            // Last resort: if placeholder is also missing, use a base64-encoded default image
                            if (!file_exists($placeholderPath) || !is_readable($placeholderPath)) {
                                $userImage = 'data:image/svg+xml;base64,' . base64_encode(
                                    '<svg xmlns="http://www.w3.org/2000/svg" width="160" height="160" viewBox="0 0 160 160"><circle cx="80" cy="80" r="80" fill="#ccc"/><path d="M80 40a24 24 0 0 1 0 48 24 24 0 0 1 0-48zm0 56c20 0 36 12 36 28v4H44v-4c0-16 16-28 36-28z" fill="#fff"/></svg>'
                                );
                            }
                        }
                    }
                    ?>
                    <img id="profile-img" 
                         src="<?php echo htmlspecialchars($userImage, ENT_QUOTES, 'UTF-8'); ?>" 
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
                    <?php if ($_SESSION['user_role'] === 'admin'): ?>     
                    <div class="form-group">
                        <label for="password">New Password (optional)</label>
                        <input type="password" 
                               class="form-control" 
                               id="password" 
                               name="password" 
                               placeholder="Enter new password to change (min 6 characters)">
                        <div id="password-error" class="error-message"></div>
                    </div>
                    <?php endif; ?>
                    <?php if ($_SESSION['user_role'] === 'admin'): ?>                  
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                            <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                        </select>
                    </div>
                    <?php endif; ?>
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