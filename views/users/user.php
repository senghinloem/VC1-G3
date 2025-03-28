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
    <title>User Management Dashboard</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Table container for horizontal and vertical scrolling */
        .table-container {
            transition: opacity 0.3s ease;
            max-height: 500px; /* Set a maximum height for the table */
            overflow-y: auto; /* Enable vertical scrolling */
            overflow-x: auto; /* Enable horizontal scrolling */
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            position: relative; /* For sticky header positioning */
        }

        .table-container.loading {
            opacity: 0.5;
            pointer-events: none;
        }

        /* Table styling */
        .user-table {
            margin-bottom: 0;
            width: 100%;
            min-width: 800px;
            border-collapse: separate;
            border-spacing: 0;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }

        /* Table headers with sticky positioning */
        .user-table th {
            background: linear-gradient(180deg, #f8f9fa, #f1f3f5);
            font-weight: 700;
            color: #2c3e50;
            padding: 18px 24px;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
            border-bottom: 2px solid #dee2e6;
            vertical-align: middle;
            white-space: nowrap;
            position: sticky; /* Sticky header */
            top: 0; /* Stick to the top of the container */
            z-index: 1; /* Ensure header stays above body content */
            background-color: #f8f9fa; /* Solid background to prevent overlap visibility */
        }

        /* Table cells */
        .user-table td {
            vertical-align: middle;
            padding: 5px 5px;
            color: #495057;
            border-bottom: 1px solid #eceff1;
            white-space: nowrap;
            transition: background-color 0.2s ease;
        }

        /* Alternating row colors with increased specificity */
        table.user-table tbody tr:nth-child(odd) {
            background-color: #e9ecef; /* Gray for odd rows */
        }

        table.user-table tbody tr:nth-child(even) {
            background-color: #fff; /* White for even rows */
        }

        /* Hover effect */
        table.user-table tbody tr:hover {
            background-color: #f5f7fa !important;
            box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.05);
        }

        /* Ensure empty state doesn’t inherit odd/even styling */
        table.user-table tbody tr td[colspan="6"] {
            background-color: transparent;
        }

        /* User avatar alignment */
        .user-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #6c757d;
            overflow: hidden;
            color: #fff;
            margin-right: 12px;
            border: 2px solid #ffffff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* User name and email */
        .user-name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 1rem;
        }

        .user-email {
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Status badges */
        .user-status {
            padding: 5px 8px;
            border-radius: 50px;
            display: inline-block;
            min-width: 50px;
            text-align: center;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: capitalize;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .user-status.online {
            background-color: #10b981;
            color: #ffffff;
        }

        .user-status.offline {
            background-color: #ff0000;
            color: #ffffff;
        }

        /* Action buttons */
        .action-btn {
            background: transparent;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 0.5rem 1rem;
            font-size: 1.1rem;
            transition: color 0.2s ease;
        }

        .action-btn:hover {
            color: #0d6efd;
        }

        /* Remove bottom border on last row */
        .user-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .user-table th,
            .user-table td {
                padding: 14px 12px;
            }

            .user-status {
                min-width: 70px;
                font-size: 0.85rem;
                padding: 6px 12px;
            }

            .user-avatar {
                width: 36px;
                height: 36px;
                margin-right: 8px;
            }

            .action-btn {
                padding: 0.3rem 0.7rem;
                font-size: 1rem;
            }

            .user-name {
                font-size: 0.95rem;
            }

            .user-email {
                font-size: 0.85rem;
            }
        }

        /* Search loading state */
        .search-container .spinner {
            display: none;
            margin-left: 10px;
            color: #0d6efd;
        }

        .search-container.loading .spinner {
            display: inline-block;
        }

        /* Stat cards */
        .stat-card {
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            height: 100%;
        }

        .stat-card h3 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .stat-card p {
            margin-bottom: 0;
            color: #6c757d;
            font-weight: 500;
        }

        .stat-card.total-users {
            background-color: #e3f2fd;
        }

        .stat-card.online-users {
            background-color: #e8f5e9;
        }

        .stat-card.offline-users {
            background-color: #ffebee;
        }

        .stat-card.online-rate {
            background-color: #fff8e1;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 40px 0;
        }

        .empty-state i {
            font-size: 3rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }

        /* Card styling */
        .card {
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            border: none;
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0,0,0,0.08);
            padding: 1rem 1.5rem;
        }

        /* Modal styling */
        .modal-content {
            border: none;
            border-radius: 12px;
        }

        .modal-header {
            border-bottom: 1px solid rgba(0,0,0,0.08);
        }

        .modal-footer {
            border-top: 1px solid rgba(0,0,0,0.08);
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid py-4">
        <div class="row mb-4 mx-2">
            <!-- Header Card -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <h4 class="mb-0 d-flex align-items-center">
                                <i class="fas fa-users me-2 text-primary"></i> User Management
                            </h4>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="search-container">
                                    <form action="/users/search" method="GET" class="d-flex align-items-center" id="searchForm">
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="fas fa-search text-muted"></i>
                                            </span>
                                            <input type="text" name="search" class="form-control border-start-0" 
                                                   placeholder="Search users..." 
                                                   value="<?= htmlspecialchars($searchQuery ?? '') ?>" 
                                                   id="searchInput">
                                        </div>
                                        <i class="fas fa-spinner fa-spin spinner ms-2"></i>
                                        <?php if (isset($error)): ?>
                                            <div class="text-danger mt-2"><?= htmlspecialchars($error) ?></div>
                                        <?php endif; ?>
                                    </form>
                                </div>
                                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                                <a href="/users/create" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add User
                                
                                </a>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stat Cards -->
            <div class="col-12 mb-4">
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="stat-card total-users">
                            <h3><?= number_format($totalUsers ?? 0) ?></h3>
                            <p>Total Users</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="stat-card online-users">
                            <h3><?= number_format($activeUsers ?? 0) ?></h3>
                            <p>Online Users</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="stat-card offline-users">
                            <h3><?= number_format($inactiveUsers ?? 0) ?></h3>
                            <p>Offline Users</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="stat-card online-rate">
                            <h3><?= number_format(($activeUsers / max(1, $totalUsers ?? 1)) * 100, 1) ?>%</h3>
                            <p>Online Rate</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- User Table -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-container">
                            <table class="user-table table-borderless">
                                <thead>
                                    <tr>
                                        <th class="text-center">User</th>
                                        <th class="text-center">First Name</th>
                                        <th class="text-center">Last Name</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Status</th>

                                
                                        <?php if ($_SESSION['user_role'] === 'admin'): ?>
                                        <th class="text-center">Actions</th>
                                        <?php endif; ?>
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
                                                <td class="text-center">
                                                    <div class="user-avatar">
                                                        <?php if (!empty($user['image'])): ?>
                                                            <img src="/uploads/<?= htmlspecialchars($user['image']) ?>" alt="<?= htmlspecialchars($user['first_name']) ?>">
                                                        <?php else: ?>
                                                            <i class="fas fa-user"></i>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="fw-semibold"><?= htmlspecialchars($user['first_name']) ?></div>
                                                </td>
                                                <td class="text-center"><?= htmlspecialchars($user['last_name']) ?></td>
                                                <td class="user-email text-center">
                                                    <div><?= htmlspecialchars($user['email']) ?></div>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                    $isOnline = $user['last_activity'] && 
                                                               (strtotime($user['last_activity']) >= strtotime('-15 minutes'));
                                                    ?>
                                                    <span class="user-status <?= $isOnline ? 'online' : 'offline' ?>">
                                                        <?= htmlspecialchars($isOnline ? 'Online' : 'Offline') ?>
                                                    </span>
                                                </td>
                                                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                                                <td class="text-center">
                                                    <button class="action-btn" type="button" 
                                                            data-bs-toggle="dropdown" 
                                                            aria-expanded="false"
                                                            data-bs-toggle="tooltip" 
                                                            title="Actions">
                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                            
                                                        <li>
                                                            <a class="dropdown-item" href="/users/detail/<?= $user['user_id'] ?>">
                                                                <i class="fas fa-eye text-primary me-2"></i> View
                                                            </a>
                                                        </li>
                                                        
                                                        <li>
                                                            <a class="dropdown-item" href="/users/edit/<?= $user['user_id'] ?>">
                                                                <i class="fas fa-edit text-success me-2"></i> Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <button type="button" 
                                                                    class="dropdown-item text-danger" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#confirmDeleteModal" 
                                                                    data-userid="<?= $user['user_id'] ?>" 
                                                                    data-username="<?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>">
                                                                <i class="fas fa-trash-alt me-2"></i> Delete
                                                            </button>
                                                            
                                                        </li>
                                                    </ul>
                                                </td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            
                            <!-- Pagination -->
                            <?php if (!empty($users) && ($totalPages ?? 0) > 1): ?>
                                <div class="card-footer bg-white py-3">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination justify-content-center mb-0">
                                            <li class="page-item <?= ($currentPage ?? 1) <= 1 ? 'disabled' : '' ?>">
                                                <a class="page-link" href="?page=<?= ($currentPage ?? 1) - 1 ?><?= isset($searchQuery) ? '&search=' . urlencode($searchQuery) : '' ?>" aria-label="Previous">
                                                    <span aria-hidden="true">«</span>
                                                </a>
                                            </li>
                                            
                                            <?php for ($i = 1; $i <= ($totalPages ?? 1); $i++): ?>
                                                <li class="page-item <?= $i === ($currentPage ?? 1) ? 'active' : '' ?>">
                                                    <a class="page-link" href="?page=<?= $i ?><?= isset($searchQuery) ? '&search=' . urlencode($searchQuery) : '' ?>">
                                                        <?= $i ?>
                                                    </a>
                                                </li>
                                            <?php endfor; ?>
                                            
                                            <li class="page-item <?= ($currentPage ?? 1) >= ($totalPages ?? 1) ? 'disabled' : '' ?>">
                                                <a class="page-link" href="?page=<?= ($currentPage ?? 1) + 1 ?><?= isset($searchQuery) ? '&search=' . urlencode($searchQuery) : '' ?>" aria-label="Next">
                                                    <span aria-hidden="true">»</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            <?php endif; ?>
                        </div>
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
            // Initialize tooltips (Note: Bootstrap JS is not included, so this won't work without it)
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, { trigger: 'hover' });
            });

            // Initialize dropdowns (Note: Bootstrap JS is not included, so this won't work without it)
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
            var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl);
            });

            // Handle delete modal (Note: Bootstrap JS is not included, so modal won't work without it)
            var confirmDeleteModal = document.getElementById('confirmDeleteModal');
            if (confirmDeleteModal) {
                confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;
                    var userId = button.getAttribute('data-userid');
                    var userName = button.getAttribute('data-username');
                    
                    var userNameElement = document.getElementById('deleteUserName');
                    if (userNameElement) userNameElement.textContent = userName;
                    
                    var form = document.getElementById('deleteForm');
                    if (form) form.action = "/users/destroy/" + userId;
                });

                confirmDeleteModal.addEventListener('show.bs.modal', function () {
                    tooltipList.forEach(function(tooltip) { tooltip.hide(); });
                });
            }

            // Search functionality with loading states
            const searchInput = document.getElementById('searchInput');
            const searchForm = document.getElementById('searchForm');
            const searchContainer = document.querySelector('.search-container');
            const tableContainer = document.querySelector('.table-container');
            let debounceTimeout;

            // Function to reset loading states
            function resetLoadingStates() {
                searchContainer.classList.remove('loading');
                tableContainer.classList.remove('loading');
            }

            // Handle search input
            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimeout);
                const query = this.value.trim();

                debounceTimeout = setTimeout(() => {
                    if (query.length === 0 || query.length >= 1) {
                        searchContainer.classList.add('loading');
                        tableContainer.classList.add('loading');
                        searchForm.submit();
                    }
                }, 500);
            });

            // Reset loading states on page load or after navigation
            window.addEventListener('load', resetLoadingStates);
            window.addEventListener('pageshow', resetLoadingStates);
            resetLoadingStates();
        });
    </script>
</body>
</html>