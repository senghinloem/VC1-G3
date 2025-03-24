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
    <title>User Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="views/assets/css/user.css">
    <style>
        .user-status.online {
            background-color: green;
            color: #155724;
            padding: 4px 8px;
            border-radius: 12px;
            display: inline-block;
            min-width: 60px;
            text-align: center;
            color: #ffffff; 
        }

        .user-status.offline {
            background-color: red;
            color: #721c24;
            padding: 4px 8px;
            border-radius: 12px;
            display: inline-block;
            min-width: 60px;
            text-align: center;
            color: #ffffff; 
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row mb-4 m-4 align-items-center">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex flex-wrap justify-content-between align-items-center header-actions">
                        <h4 class="mb-0 d-flex align-items-center">
                            <i class="fas fa-users me-2 text-primary"></i> User Management
                        </h4>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="search-container">
                                <form action="/users/search" method="GET" class="d-flex">
                                    <i class="fas fa-search search-icon"></i>
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Search users..." 
                                           value="<?= htmlspecialchars($searchQuery ?? '') ?>">
                                    <?php if (isset($error)): ?>
                                        <div class="text-danger mt-2"><?= htmlspecialchars($error) ?></div>
                                    <?php endif; ?>
                                </form>
                            </div>
                            <a href="/users/create" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Add User
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="container">
                <div class="col-md-3 col-6 mb-3">
                    <div class="stat-card total-orders">
                        <h3><?= number_format($totalUsers ?? 0) ?></h3>
                        <p>Total Users</p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="stat-card total-delivered">
                        <h3><?= number_format($activeUsers ?? 0) ?></h3>
                        <p>Online Users</p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="stat-card pending-orders">
                        <h3><?= number_format($inactiveUsers ?? 0) ?></h3>
                        <p>Offline Users</p>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="stat-card orders-on-hold">
                        <h3><?= number_format(($activeUsers ?? 0) / max(1, ($totalUsers ?? 1)) * 100, 1) ?>%</h3>
                        <p>Online Rate</p>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($users)): ?>
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <i class="fas fa-users-slash"></i>
                                            <h5>No users found</h5>
                                            <p>There are no users matching your criteria or no users have been added yet.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td>
                                            <div class="user-avatar">
                                                <?php if (!empty($user['image'])): ?>
                                                    <img src="/uploads/<?= htmlspecialchars($user['image']) ?>" alt="<?= htmlspecialchars($user['first_name']) ?>">
                                                <?php else: ?>
                                                    <i class="fas fa-user"></i>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold"><?= htmlspecialchars($user['first_name']) ?></div>
                                        </td>
                                        <td><?= htmlspecialchars($user['last_name']) ?></td>
                                        <td>
                                            <div class="text-muted"><?= htmlspecialchars($user['email']) ?></div>
                                        </td>
                                        <td>
                                            <?php
                                            $isOnline = $user['last_activity'] && 
                                                       (strtotime($user['last_activity']) >= strtotime('-15 minutes'));
                                            ?>
                                            <span class="user-status <?= $isOnline ? 'online' : 'offline' ?>">
                                                <?= htmlspecialchars($isOnline ? 'Online' : 'Offline') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <div class="dropdown">
                                                    <button class="action-btn dropdown-toggle" type="button" 
                                                            id="dropdownMenuButton<?= $user['user_id'] ?>" 
                                                            data-bs-toggle="dropdown" 
                                                            aria-expanded="false" 
                                                            data-bs-toggle="tooltip" 
                                                            title="Actions">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" 
                                                        aria-labelledby="dropdownMenuButton<?= $user['user_id'] ?>">
                                                        <li>
                                                            <a class="dropdown-item" href="/users/view/<?= $user['user_id'] ?>">
                                                                <i class="fas fa-eye text-primary"></i> View
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="/users/edit/<?= $user['user_id'] ?>">
                                                                <i class="fas fa-edit text-success"></i> Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <button type="button" 
                                                                    class="dropdown-item text-danger" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#confirmDeleteModal" 
                                                                    data-userid="<?= $user['user_id'] ?>" 
                                                                    data-username="<?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>">
                                                                <i class="fas fa-trash-alt"></i> Delete
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if (!empty($users) && isset($totalPages) && $totalPages > 1): ?>
                    <div class="card-footer bg-white">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center mb-0">
                                <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $currentPage - 1 ?><?= isset($searchQuery) ? '&search=' . urlencode($searchQuery) : '' ?>" aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                    </a>
                                </li>
                                
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?><?= isset($searchQuery) ? '&search=' . urlencode($searchQuery) : '' ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                                
                                <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $currentPage + 1 ?><?= isset($searchQuery) ? '&search=' . urlencode($searchQuery) : '' ?>" aria-label="Next">
                                        <span aria-hidden="true">»</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                <?php endif; ?>
            </div>
        </div>

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
                        <form id="deleteForm" method="POST">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt me-2"></i>Delete User
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl, {
                        trigger: 'hover'
                    });
                });

                var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
                var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                    return new bootstrap.Dropdown(dropdownToggleEl);
                });
                
                var confirmDeleteModal = document.getElementById('confirmDeleteModal');
                if (confirmDeleteModal) {
                    confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
                        var button = event.relatedTarget;
                        var userId = button.getAttribute('data-userid');
                        var userName = button.getAttribute('data-username');
                        
                        var userNameElement = document.getElementById('deleteUserName');
                        if (userNameElement) {
                            userNameElement.textContent = userName;
                        }
                        
                        var form = document.getElementById('deleteForm');
                        if (form) {
                            form.action = "/users/destroy/" + userId;
                        }
                    });
                }
                
                confirmDeleteModal.addEventListener('show.bs.modal', function () {
                    tooltipList.forEach(function(tooltip) {
                        tooltip.hide();
                    });
                });
            });
        </script>
    </body>
</html>