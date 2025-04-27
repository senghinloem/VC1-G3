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
</head>
<body>
    <div class="main-content">
        <div class="profile-container">
            <div class="profile-header">
                <div class="profile-avatar">
                    <?php
                    $userImage = isset($_SESSION['image']) && !empty($_SESSION['image']) 
                        ? '/uploads/' . htmlspecialchars($_SESSION['image'], ENT_QUOTES, 'UTF-8') 
                        : '/views/assets/img/user2-160x160.jpg';
                    $imagePath = $_SERVER['DOCUMENT_ROOT'] . $userImage;
                    if (!file_exists($imagePath)) {
                        $userImage = '/views/assets/img/user2-160x160.jpg';
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