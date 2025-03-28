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
    <style>
        :root {
            --primary-color: #007bff;
            --sidebar-bg: #1a1a1a;
            --bg-color: #f8f9fa;
            --text-dark: #333333;
            --text-light: #666666;
            --success-color: #28a745;
            --danger-color: #dc3545;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg-color);
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
            color: var(--text-dark);
            overflow-x: hidden;
        }
        /* Main Content */
        .main-content {
            margin-left: 250px;
            margin-top: 5px;
            margin-left: 120px;
            padding: 40px;
            width: calc(100% - 250px);
            min-height: calc(100vh - 70px);
            display: flex;
            justify-content: center;
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        .main-content.full-screen {
            margin-left: 0;
            width: 100%;
        }

        .profile-container {
            width: 100%;
            max-width: 600px;
            background: white;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }

        .profile-avatar i {
            font-size: 2.5rem;
            color: var(--primary-color);
        }

        .profile-name {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .profile-email {
            font-size: 1rem;
            color: var(--text-light);
            margin-bottom: 10px;
        }

        .profile-status {
            font-size: 0.9rem;
            font-weight: 500;
        }

        .profile-status.online {
            color: var(--success-color);
        }

        .profile-status.offline {
            color: var(--danger-color);
        }

        .profile-details {
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .detail-label {
            font-weight: 500;
            color: var(--text-dark);
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .detail-label i {
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        .detail-value {
            font-weight: 400;
            color: var(--text-light);
            font-size: 1rem;
        }

        .btn-edit {
            display: block;
            margin: 20px auto 0;
            padding: 10px 20px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            text-align: center;
            text-decoration: none;
        }

        .btn-edit:hover {
            background: #0056b3;
        }

        @media (max-width: 1024px) {
            .sidebar {
                width: 200px;
            }

            .navbar {
                left: 200px;
                width: calc(100% - 200px);
            }

            .main-content {
                margin-left: 200px;
                width: calc(100% - 200px);
            }

            .profile-container {
                max-width: 500px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
            }

            .sidebar h2, .sidebar ul li a span {
                display: none;
            }

            .sidebar ul li a {
                justify-content: center;
            }

            .navbar {
                left: 60px;
                width: calc(100% - 60px);
            }

            .main-content {
                margin-left: 60px;
                width: calc(100% - 60px);
            }

            .profile-container {
                padding: 20px;
            }

            .profile-name {
                font-size: 1.5rem;
            }

            .profile-email {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .profile-container {
                max-width: 100%;
                padding: 15px;
            }

            .profile-avatar {
                width: 80px;
                height: 80px;
            }

            .profile-avatar i {
                font-size: 2rem;
            }

            .profile-name {
                font-size: 1.3rem;
            }

            .detail-label, .detail-value {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
  
    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <div class="profile-container">
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user-astronaut"></i>
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
                    <span class="detail-label"><i class="fas fa-envelope"></i> Email</span>
                    <span class="detail-value"><?= htmlspecialchars($_SESSION['email']) ?></span>
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
            </div>
            <a href="/users/edit/<?= $_SESSION['user_id'] ?>" class="btn btn-edit">
                <i class="fas fa-edit"></i> Edit Profile
            </a>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const navbar = document.getElementById('navbar');
            const mainContent = document.getElementById('main-content');

            sidebar.classList.toggle('hidden');
            navbar.classList.toggle('full-screen');
            mainContent.classList.toggle('full-screen');
        }
    </script>
</body>
</html>