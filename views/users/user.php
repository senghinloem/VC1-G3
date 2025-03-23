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
    <title>User Management Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-hover: #3a56d4;
            --success-color: #06d6a0;
            --success-hover: #05c090;
            --warning-color: #ffd166;
            --warning-hover: #ffc233;
            --danger-color: #ef476f;
            --danger-hover: #e62e5c;
            --light-bg: #f8f9fa;
            --card-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
            --border-radius: 0.75rem;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-bg);
            color: #333;
            margin: 0;
            padding: 0;
            font-size: 0.9rem;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 1.5rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            font-weight: 700;
            font-size: 1.5rem;
            color: #333;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .header h1 i {
            color: var(--primary-color);
            margin-right: 0.75rem;
            font-size: 1.25rem;
        }

        .search-container {
            position: relative;
            width: 300px;
        }

        .search-container input {
            width: 100%;
            padding: 0.6rem 1rem 0.6rem 2.5rem;
            border: 1px solid #e0e0e0;
            border-radius: 50px;
            background-color: white;
            font-size: 0.85rem;
            transition: all 0.3s;
        }

        .search-container input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            line-height: 1;
        }

        .total-users { color: var(--primary-color); }
        .active-users { color: var(--success-color); }
        .inactive-users { color: #6c757d; }
        .admin-users { color: var(--warning-color); }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            font-weight: 500;
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
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h2 {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 50px;
            padding: 0.4rem 1.25rem;
            font-weight: 500;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
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
            padding: 0.75rem 1.25rem;
            position: sticky;
            top: 0;
            z-index: 10;
            font-size: 0.9rem;
        }

        .table tbody td {
            padding: 0.75rem 1.25rem;
            vertical-align: middle;
            border-bottom: 1px solid #f2f2f2;
            font-size: 0.85rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .table tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.03);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table th:nth-child(1), .table td:nth-child(1) { width: 8%; }
        .table th:nth-child(2), .table td:nth-child(2) { width: 12%; }
        .table th:nth-child(3), .table td:nth-child(3) { width: 12%; }
        .table th:nth-child(4), .table td:nth-child(4) { width: 20%; }
        .table th:nth-child(5), .table td:nth-child(5) { width: 12%; }
        .table th:nth-child(6), .table td:nth-child(6) { width: 12%; }
        .table th:nth-child(7), .table td:nth-child(7) { width: 12%; }
        .table th:nth-child(8), .table td:nth-child(8) { width: 26%; }

        .user-avatar {
            width: 45px;
            height: 45px;
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
            padding: 0.2rem 0.6rem;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .role-admin { background-color: rgba(67, 97, 238, 0.1); color: var(--primary-color); }
        .role-manager { background-color: rgba(6, 214, 160, 0.1); color: var(--success-color); }
        .role-user { background-color: rgba(255, 209, 102, 0.1); color: var(--warning-color); }
        .role-guest { background-color: rgba(239, 71, 111, 0.1); color: var(--danger-color); }

        .status-active {
            background-color: rgba(6, 214, 160, 0.15);
            color: var(--success-color);
            padding: 0.3rem 0.9rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid rgba(6, 214, 160, 0.3);
            transition: all 0.3s ease;
        }

        .status-active:hover {
            background-color: rgba(6, 214, 160, 0.25);
            box-shadow: 0 0 8px rgba(6, 214, 160, 0.3);
        }

        .status-inactive {
            background-color: rgba(108, 117, 125, 0.15);
            color: #6c757d;
            padding: 0.3rem 0.9rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid rgba(108, 117, 125, 0.3);
            transition: all 0.3s ease;
        }

        .status-inactive:hover {
            background-color: rgba(108, 117, 125, 0.25);
            box-shadow: 0 0 8px rgba(108, 117, 125, 0.3);
        }

        .action-dropdown {
            position: relative;
            text-align: center;
        }

        .action-dropdown-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            color: #6c757d;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .action-dropdown-btn:hover {
            background: linear-gradient(135deg, #e9ecef, #dee2e6);
            color: #495057;
            transform: scale(1.05);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .action-dropdown-btn i {
            font-size: 1.2rem;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            border-radius: 0.5rem;
            padding: 0.75rem 0;
            animation: slideIn 0.2s ease-out;
        }

        .dropdown-item {
            padding: 0.6rem 1rem;
            transition: all 0.2s ease;
            font-size: 0.85rem;
            display: flex;
            align-items: center; /* Align icon and text vertically */
        }

        .dropdown-item:hover {
            background-color: rgba(67, 97, 238, 0.1);
            transform: translateX(5px);
        }

        .dropdown-item.text-danger:hover {
            background-color: rgba(239, 71, 111, 0.1);
        }

        .dropdown-item i {
            font-size: 0.9rem;
            margin-right: 0.5rem;
            display: inline-block; /* Ensure visibility */
            width: auto;
            height: auto;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
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

        .modal-title {
            font-size: 1.25rem;
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
            padding: 0.4rem 1.25rem;
            font-weight: 500;
            font-size: 0.85rem;
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
            padding: 0.4rem 1.25rem;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .btn-danger:hover {
            background-color: var(--danger-hover);
            border-color: var(--danger-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(239, 71, 111, 0.2);
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
            font-size: 1.1rem;
        }

        .empty-state p {
            color: #adb5bd;
            max-width: 300px;
            margin: 0 auto;
            font-size: 0.85rem;
        }

        .pagination {
            margin-top: 1.5rem;
            justify-content: center;
        }

        .page-link {
            border: none;
            color: #6c757d;
            padding: 0.4rem 0.65rem;
            margin: 0 0.25rem;
            border-radius: 0.25rem;
            font-size: 0.85rem;
        }

        .page-item.active .page-link {
            background-color: var(--primary-color);
            color: white;
        }

        .page-item.disabled .page-link {
            color: #dee2e6;
        }

        @media (max-width: 1200px) {
            .dashboard-container { max-width: 100%; padding: 1rem; }
        }

        @media (max-width: 992px) {
            .header { flex-direction: column; align-items: flex-start; gap: 1rem; }
            .search-container { width: 100%; }
            .card-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
            .btn-primary { width: 100%; justify-content: center; }
            .table-responsive { max-height: 500px; }
        }

        @media (max-width: 768px) {
            .table thead th:nth-child(4), .table tbody td:nth-child(4),
            .table thead th:nth-child(6), .table tbody td:nth-child(6) { display: none; }
        }

        @media (max-width: 576px) {
            .table thead th:nth-child(3), .table tbody td:nth-child(3) { display: none; }
            .card-header { padding: 1rem; }
            .table thead th, .table tbody td { padding: 0.6rem; font-size: 0.8rem; }
            .stat-number { font-size: 1.75rem; }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            <h1><i class="fas fa-users"></i> User Management</h1>
        </div>
        
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-number total-users"><?= $totalUsers ?? 0 ?></div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-number active-users"><?= $totalActiveUsers ?? 0 ?></div>
                <div class="stat-label">Active Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-number inactive-users"><?= $totalInactiveUsers ?? 0 ?></div>
                <div class="stat-label">Inactive Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-number admin-users"><?= $totalAdminUsers ?? 0 ?></div>
                <div class="stat-label">Admin Users</div>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header">
                <h2>Users</h2>
                <div class="search-container">
                    <form action="/users/search" method="GET" class="d-flex">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" name="search" placeholder="Search users..." value="<?= htmlspecialchars($searchQuery ?? '') ?>">
                    </form>
                </div>
                <a href="/users/create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add User
                </a>
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
                                <th>Phone</th>
                                <th>Status</th>
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
                                <?php foreach ($users as $index => $user): ?>
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
                                        <td><?= htmlspecialchars($user['phone']) ?></td>
                                        <td>
                                            <span class="status-<?= $user['status'] == 1 ? 'active' : 'inactive' ?>">
                                                <?= $user['status'] == 1 ? 'Active' : 'Inactive' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-dropdown">
                                                <div class="dropdown">
                                                    <button class="action-dropdown-btn" type="button" id="dropdownMenuButton<?= $index ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton<?= $index ?>">
                                                        <li><a class="dropdown-item" href="/users/view/<?= $user['user_id'] ?>"><i class="fas fa-eye text-primary"></i> View</a></li>
                                                        <li><a class="dropdown-item" href="/users/edit/<?= $user['user_id'] ?>"><i class="fas fa-edit text-success"></i> Edit</a></li>
                                                        <li><a class="dropdown-item" href="/users/reset-password/<?= $user['user_id'] ?>"><i class="fas fa-key text-warning"></i> Reset Password</a></li>
                                                        <li><button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-userid="<?= $user['user_id'] ?>" data-username="<?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>"><i class="fas fa-trash-alt"></i> Delete</button></li>
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
            
            <!-- Pagination -->
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            var tooltipList = Array.from(tooltipTriggerList).map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, { trigger: 'hover' });
            });

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
        });
    </script>
</body>
</html>