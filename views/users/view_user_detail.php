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
    <title>User Details - <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid py-4">
        <div class="user-detail-card">
            <div class="user-header">
                <div class="user-avatar-large">
                    <?php if (!empty($user['image'])): ?>
                        <img src="/uploads/<?= htmlspecialchars($user['image']) ?>" alt="<?= htmlspecialchars($user['first_name']) ?>">
                    <?php else: ?>
                        <i class="fas fa-user" style="font-size: 48px; color: #fff; background: #6c757d; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;"></i>
                    <?php endif; ?>
                </div>
                <div class="flex-grow-1">
                    <h2 class="mb-1"><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h2>
                    <p class="mb-2 text-muted"><?= htmlspecialchars($user['email']) ?></p>
                    <?php
                    $isOnline = $user['last_activity'] && 
                               (strtotime($user['last_activity']) >= strtotime('-15 minutes'));
                    ?>
                    <span class="user-status <?= $isOnline ? 'online' : 'offline' ?>">
                        <?= htmlspecialchars($isOnline ? 'Online' : 'Offline') ?>
                    </span>
                </div>
            </div>
            
            <div class="card-body p-0">
                <div class="detail-item">
                    <span class="detail-label">First Name:</span>
                    <span class="detail-value"><?= htmlspecialchars($user['first_name']) ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Last Name:</span>
                    <span class="detail-value"><?= htmlspecialchars($user['last_name']) ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value"><?= htmlspecialchars($user['email']) ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Phone:</span>
                    <span class="detail-value"><?= htmlspecialchars($user['phone'] ?? 'Not provided') ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Role:</span>
                    <span class="detail-value"><?= htmlspecialchars($user['role'] ?? 'Not assigned') ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Last Activity:</span>
                    <span class="detail-value">
                        <?= $user['last_activity'] ? date('F j, Y, g:i a', strtotime($user['last_activity'])) : 'Never' ?>
                    </span>
                </div>
            </div>
            
            <div class="card-footer bg-white py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <a href="/users" class="btn btn-custom btn-back">
                        <i class="fas fa-arrow-left"></i> Back to Users
                    </a>
                    <div class="d-flex gap-2">
                        <a href="/users/edit/<?= $user['user_id'] ?>" class="btn btn-custom btn-edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button type="button" class="btn btn-custom btn-delete" 
                                data-bs-toggle="modal" 
                                data-bs-target="#confirmDeleteModal" 
                                data-userid="<?= $user['user_id'] ?>" 
                                data-username="<?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-3">
                        <i class="fas fa-exclamation-triangle text-warning fa-3x"></i>
                    </div>
                    <h5 class="mb-2">Are you sure?</h5>
                    <p class="text-muted mb-0">You are about to delete user <strong id="deleteUserName"></strong>. This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" action="">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-2"></i> Delete User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const confirmDeleteModal = document.getElementById('confirmDeleteModal');
            if (confirmDeleteModal) {
                confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const userId = button.getAttribute('data-userid');
                    const userName = button.getAttribute('data-username');
                    
                    const userNameElement = document.getElementById('deleteUserName');
                    if (userNameElement) userNameElement.textContent = userName;
                    
                    const form = document.getElementById('deleteForm');
                    if (form) form.action = "/users/destroy/" + userId;
                });
            }
        });
    </script>
</body>
</html>