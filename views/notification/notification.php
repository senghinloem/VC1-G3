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
    <title>Notifications - PNN SHOP</title>
    <link rel="stylesheet" href="/views/assets/css/adminlte.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .notification-item.unread {
            background-color: rgba(13, 110, 253, 0.05);
            border-left: 3px solid #0d6efd;
        }
        .notification-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        .animate-pulse {
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
        .notification-badge {
            font-size: 0.7rem;
            top: 5px;
            right: 5px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Notifications</h1>
            <div class="btn-group">
                <form method="POST" action="/notification" class="me-2">
                    <button type="submit" name="mark_as_read" class="btn btn-primary">
                        <i class="bi bi-check-all me-1"></i> Mark All as Read
                    </button>
                </form>
                <form method="POST" action="/notification" onsubmit="return confirm('Are you sure you want to clear all notifications?')">
                    <button type="submit" name="clear_all" class="btn btn-outline-danger">
                        <i class="bi bi-trash me-1"></i> Clear All
                    </button>
                </form>
                <a href="/dashboard" class="btn btn-outline-secondary ms-2">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </a>
            </div>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['success']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <!-- Error Alert -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Styled Notification Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <?php if (empty($data['notifications'])): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-bell-slash fs-1 text-muted"></i>
                        <p class="text-muted mt-3">No notifications available</p>
                    </div>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($data['notifications'] as $notification): ?>
                            <div class="list-group-item list-group-item-action py-3 px-4 hover-bg">
                                <div class="d-flex align-items-start">
                                    <div class="notification-icon bg-<?= $data['notificationTypes'][$notification['type']]['color'] ?> text-white me-3 rounded-circle">
                                        <i class="bi <?= $data['notificationTypes'][$notification['type']]['icon'] ?>"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <p class="mb-1 fw-medium text-dark"><?= htmlspecialchars($notification['message']) ?></p>
                                            <?php if (!$notification['is_read']): ?>
                                                <span class="badge bg-primary rounded-pill ms-2">New</span>
                                            <?php endif; ?>
                                        </div>
                                        <small class="text-muted d-block"><?= date('M d, Y h:i A', strtotime($notification['created_at'])) ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('a[data-notification-id]').forEach(item => {
            item.addEventListener('click', function() {
                const notificationId = this.getAttribute('data-notification-id');
                if (notificationId) {
                    fetch(`/notification/markAsRead/${notificationId}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            this.classList.remove('unread');
                            this.querySelector('.badge')?.remove();
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>