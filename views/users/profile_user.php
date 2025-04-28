<?php
// views/users/profile_user.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit();
}

$lastActivity = $_SESSION['last_activity'] ?? date('Y-m-d H:i:s');
$isOnline = $lastActivity && (strtotime($lastActivity) >= strtotime('-15 minutes'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - PNN Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/views/assets/css/user_profile.css">
</head>
<body>
    <div class="main-content">
        <div class="profile-container">
            <div class="profile-header">
                <div class="profile-avatar">
                    <?php
                    // Define the default image path
                    $defaultImage = '/views/assets/img/user2-160x160.jpg';
                    // Check if user image exists in session and is valid
                    $userImage = isset($_SESSION['image']) && !empty($_SESSION['image']) 
                        ? '/uploads/' . htmlspecialchars($_SESSION['image'], ENT_QUOTES, 'UTF-8') 
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
                    <img src="<?= htmlspecialchars($userImage, ENT_QUOTES, 'UTF-8') ?>" alt="User Image">
                </div>
                <h1 class="profile-name">
                    <?= htmlspecialchars($_SESSION['first_name'] . ' ' . $_SESSION['last_name']) ?>
                </h1>
                <div class="profile-email">
                    <?= htmlspecialchars($_SESSION['email']) ?>
                </div>
                <div class="profile-status <?= $isOnline ? 'online' : 'offline' ?>">
                    <?= $isOnline ? 'Online' : 'Offline' ?>
                </div>
            </div>
            <div class="profile-details">
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-user"></i> First Name</span>
                    <span class="detail-value"><?= htmlspecialchars($_SESSION['first_name']) ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-user"></i> Last Name</span>
                    <span class="detail-value"><?= htmlspecialchars($_SESSION['last_name']) ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-phone"></i> Phone</span>
                    <span class="detail-value"><?= htmlspecialchars($_SESSION['phone'] ?? 'Not provided') ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-user-tag"></i> Role</span>
                    <span class="detail-value"><?= htmlspecialchars($_SESSION['user_role']) ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-clock"></i> Last Activity</span>
                    <span class="detail-value">
                        <?= $lastActivity ? date('M d, Y H:i', strtotime($lastActivity)) : 'Never' ?>
                    </span>
                </div>
                <a href="/users/edit/<?= $_SESSION['user_id'] ?>" class="btn btn-edit">
                    <i class="fas fa-edit"></i> Edit Profile
                </a>
            </div>
        </div>
    </div>
</body>
</html>