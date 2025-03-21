<?php
session_start();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-hover: #3a56d4;
            --danger-color: #ef476f;
            --danger-hover: #d64265;
            --success-color: #06d6a0;
            --warning-color: #ffd166;
            --light-bg: #f8f9fa;
            --card-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
            --border-radius: 0.75rem;
        }
        
        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        
        .page-container {
            max-width: 1800px;
            margin: 0 auto;
            padding: 1.5rem;
            width: 95%;
        }
        
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            overflow: hidden;
            width: 100%;
        }
        
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem 1.5rem;
        }
        
        .search-container {
            position: relative;
            max-width: 500px;
        }
        
        .search-container .form-control {
            padding-left: 2.5rem;
            height: 45px;
            border-radius: 50px;
            border: 1px solid #e0e0e0;
            box-shadow: none;
        }
        
        .search-container .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.15);
        }
        
        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(67, 97, 238, 0.2);
        }
        
        .table-container {
            padding: 0;
            overflow: hidden;
            width: 100%;
        }
        
        .table {
            margin-bottom: 0;
            width: 100%;
            table-layout: fixed;
        }
        
        .table thead th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #495057;
            border-top: none;
            border-bottom: 2px solid #e9ecef;
            padding: 1rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .table tbody td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid #f2f2f2;
        }
        
        .table tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.03);
        }
        
        .table tbody tr:last-child td {
            border-bottom: none;
        }
        
        /* Adjusted column widths */
        .table th:nth-child(1), 
        .table td:nth-child(1) { 
            width: 8%;
        }
        
        .table th:nth-child(2), 
        .table td:nth-child(2) { 
            width: 14%;
        }
        
        .table th:nth-child(3), 
        .table td:nth-child(3) { 
            width: 14%;
        }
        
        .table th:nth-child(4), 
        .table td:nth-child(4) { 
            width: 22%;
        }
        
        .table th:nth-child(5), 
        .table td:nth-child(5) { 
            width: 14%;
        }
        
        .table th:nth-child(6), 
        .table td:nth-child(6) { 
            width: 14%;
        }
        
        .table th:nth-child(7), 
        .table td:nth-child(7) { 
            width: 14%; /* Increased width for action buttons */
        }
        
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            background-color: #f1f3f9;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 1.2rem;
        }
        
        .user-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .user-role {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .role-admin {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }
        
        .role-manager {
            background-color: rgba(6, 214, 160, 0.1);
            color: var(--success-color);
        }
        
        .role-user {
            background-color: rgba(255, 209, 102, 0.1);
            color: #ff9f1c;
        }
        
        .role-guest {
            background-color: rgba(239, 71, 111, 0.1);
            color: var(--danger-color);
        }
        
        /* NEW ENHANCED ACTION BUTTONS STYLES */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 8px;
        }
        
        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            background-color: #f8f9fa;
            color: #6c757d;
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
        }
        
        .action-btn.view-btn {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }
        
        .action-btn.view-btn:hover {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 4px 8px rgba(67, 97, 238, 0.2);
        }
        
        .action-btn.edit-btn {
            background-color: rgba(6, 214, 160, 0.1);
            color: var(--success-color);
        }
        
        .action-btn.edit-btn:hover {
            background-color: var(--success-color);
            color: white;
            box-shadow: 0 4px 8px rgba(6, 214, 160, 0.2);
        }
        
        .action-btn.delete-btn {
            background-color: rgba(239, 71, 111, 0.1);
            color: var(--danger-color);
        }
        
        .action-btn.delete-btn:hover {
            background-color: var(--danger-color);
            color: white;
            box-shadow: 0 4px 8px rgba(239, 71, 111, 0.2);
        }
        
        /* Tooltip styles */
        .tooltip-inner {
            background-color: #333;
            color: white;
            border-radius: 4px;
            padding: 5px 10px;
            font-size: 0.8rem;
        }
        
        .bs-tooltip-auto[data-popper-placement^=top] .tooltip-arrow::before, 
        .bs-tooltip-top .tooltip-arrow::before {
            border-top-color: #333;
        }
        
        /* For smaller screens, show more menu instead */
        @media (max-width: 992px) {
            .action-buttons {
                justify-content: center;
            }
            
            .action-btn.view-btn,
            .action-btn.edit-btn {
                display: none;
            }
            
            .action-btn.more-btn {
                display: inline-flex;
            }
        }
        
        @media (min-width: 993px) {
            .action-btn.more-btn {
                display: none;
            }
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            padding: 0.5rem 0;
            min-width: 12rem;
            z-index: 1021;
            margin-top: 0.5rem;
        }
        
        .dropdown-item {
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.2s;
            cursor: pointer;
            font-size: 0.95rem;
        }
        
        .dropdown-item:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }
        
        .dropdown-item.text-danger:hover {
            background-color: rgba(239, 71, 111, 0.05);
        }
        
        .dropdown-item i {
            font-size: 1rem;
        }
        
        .table-responsive {
            max-height: 700px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #ccc transparent;
        }
        
        .table-responsive::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        .table-responsive::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .table-responsive::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 20px;
        }
        
        .modal-content {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
        }
        
        .modal-dialog {
            max-width: 550px;
        }
        
        .modal-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem 1.5rem;
        }
        
        .modal-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem 1.5rem;
        }
        
        .btn-secondary {
            background-color: #e9ecef;
            border-color: #e9ecef;
            color: #495057;
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }
        
        .btn-secondary:hover {
            background-color: #dee2e6;
            border-color: #dee2e6;
            color: #212529;
        }
        
        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }
        
        .btn-danger:hover {
            background-color: var(--danger-hover);
            border-color: var(--danger-hover);
        }
        
        .empty-state {
            padding: 3rem;
            text-align: center;
        }
        
        .empty-state i {
            font-size: 3rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }
        
        .empty-state h5 {
            color: #6c757d;
            margin-bottom: 0.5rem;
        }
        
        .empty-state p {
            color: #adb5bd;
            max-width: 300px;
            margin: 0 auto;
        }
        
        .pagination {
            margin-top: 1.5rem;
            justify-content: center;
        }
        
        .page-link {
            border: none;
            color: #6c757d;
            padding: 0.5rem 0.75rem;
            margin: 0 0.25rem;
            border-radius: 0.25rem;
        }
        
        .page-item.active .page-link {
            background-color: var(--primary-color);
            color: white;
        }
        
        .page-item.disabled .page-link {
            color: #dee2e6;
        }
        
        @media (max-width: 1200px) {
            .page-container {
                max-width: 100%;
                padding: 1rem;
            }
        }
        
        @media (max-width: 992px) {
            .search-container {
                margin-bottom: 1rem;
                max-width: 100%;
            }
            
            .header-actions {
                flex-direction: column;
                align-items: stretch;
            }
            
            .table-responsive {
                max-height: 500px;
            }
        }
        
        @media (max-width: 768px) {
            .table thead th:nth-child(4),
            .table tbody td:nth-child(4),
            .table thead th:nth-child(6),
            .table tbody td:nth-child(6) {
                display: none;
            }
            
            .action-buttons {
                gap: 5px;
            }
            
            .action-btn {
                width: 32px;
                height: 32px;
            }
        }
        
        @media (max-width: 576px) {
            .table thead th:nth-child(3),
            .table tbody td:nth-child(3) {
                display: none;
            }
            
            .card-header {
                padding: 1rem;
            }
            
            .table thead th,
            .table tbody td {
                padding: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="page-container">
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
                                <input type="text" name="search" class="form-control" placeholder="Search users..." value="<?= htmlspecialchars($searchQuery ?? '') ?>">
                            </form>
                        </div>
                        <a href="/users/create" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add User
                        </a>
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
                                <th>Role</th>
                                <th>Phone</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($users)): ?>
                                <tr>
                                    <td colspan="7">
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
                                                <?php if ($user['image']): ?>
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
                                            $roleClass = 'role-user';
                                            if (strtolower($user['role']) === 'admin') {
                                                $roleClass = 'role-admin';
                                            } elseif (strtolower($user['role']) === 'manager') {
                                                $roleClass = 'role-manager';
                                            } elseif (strtolower($user['role']) === 'guest') {
                                                $roleClass = 'role-guest';
                                            }
                                            ?>
                                            <span class="user-role <?= $roleClass ?>"><?= htmlspecialchars($user['role']) ?></span>
                                        </td>
                                        <td><?= htmlspecialchars($user['phone']) ?></td>
                                        <td>
                                            <!-- NEW ENHANCED ACTION BUTTONS -->
                                            <div class="action-buttons">
                                                <!-- View button -->
                                                
                                                <!-- Edit button -->
                                                <a href="/users/edit/<?= $user['user_id'] ?>" class="action-btn edit-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit User">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                <!-- Delete button -->
                                                <button type="button" class="action-btn delete-btn" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-userid="<?= $user['user_id'] ?>" data-username="<?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete User">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                
                                                <!-- More options button (for mobile) -->
                                                <div class="dropdown">
                                                    <button class="action-btn more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-toggle="tooltip" data-bs-placement="top" title="More Options">
                                                        <i class="fas fa-ellipsis-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a class="dropdown-item" href="/users/edit/<?= $user['user_id'] ?>">
                                                                <i class="fas fa-edit text-success"></i> Edit
                                                            </a>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-userid="<?= $user['user_id'] ?>" data-username="<?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>">
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
            </div>
            
            <!-- Pagination - Add if needed -->
            <?php if (!empty($users) && isset($totalPages) && $totalPages > 1): ?>
            <div class="card-footer bg-white">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center mb-0">
                        <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $currentPage - 1 ?><?= isset($searchQuery) ? '&search=' . urlencode($searchQuery) : '' ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
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
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Enhanced Delete Confirmation Modal -->
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    trigger: 'hover'
                });
            });
            
            // Handle delete confirmation modal
            var confirmDeleteModal = document.getElementById('confirmDeleteModal');
            if (confirmDeleteModal) {
                confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;
                    var userId = button.getAttribute('data-userid');
                    var userName = button.getAttribute('data-username');
                    
                    // Update the modal's content
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
            
            // Fix for tooltip conflicts with modal
            confirmDeleteModal.addEventListener('show.bs.modal', function () {
                tooltipList.forEach(function(tooltip) {
                    tooltip.hide();
                });
            });
        });
    </script>
</body>
</html>