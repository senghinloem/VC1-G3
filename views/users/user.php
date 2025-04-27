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
                                    <form action="/users/search" method="GET" class="d-flex align-items-center"
                                        id="searchForm">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control border-start-0"
                                                placeholder="Search users..."
                                                value="<?= htmlspecialchars($searchQuery ?? '') ?>" id="searchInput">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                    <?php if (isset($error)): ?>
                                        <div class="text-danger mt-2"><?= htmlspecialchars($error) ?></div>
                                    <?php endif; ?>
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
                                                    <p>There are no users matching your criteria or no users have been added
                                                        yet.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($users as $user): ?>
                                            <tr>
                                                <td class="text-center">
                                                    <div class="user-avatar">
                                                        <?php if (!empty($user['image'])): ?>
                                                            <img src="/uploads/<?= htmlspecialchars($user['image']) ?>"
                                                                alt="<?= htmlspecialchars($user['first_name']) ?>">
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
                                                        <button class="action-btn" type="button" data-bs-toggle="dropdown"
                                                            aria-expanded="false" data-bs-toggle="tooltip" title="Actions">
                                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end">

                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="/users/detail/<?= $user['user_id'] ?>">
                                                                    <i class="fas fa-eye text-primary me-2"></i> View
                                                                </a>
                                                            </li>

                                                            <li>
                                                                <a class="dropdown-item" href="/users/edit/<?= $user['user_id'] ?>">
                                                                    <i class="fas fa-edit text-success me-2"></i> Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="dropdown-item text-danger"
                                                                    data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"
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
                                                <a class="page-link"
                                                    href="?page=<?= ($currentPage ?? 1) - 1 ?><?= isset($searchQuery) ? '&search=' . urlencode($searchQuery) : '' ?>"
                                                    aria-label="Previous">
                                                    <span aria-hidden="true">«</span>
                                                </a>
                                            </li>

                                            <?php for ($i = 1; $i <= ($totalPages ?? 1); $i++): ?>
                                                <li class="page-item <?= $i === ($currentPage ?? 1) ? 'active' : '' ?>">
                                                    <a class="page-link"
                                                        href="?page=<?= $i ?><?= isset($searchQuery) ? '&search=' . urlencode($searchQuery) : '' ?>">
                                                        <?= $i ?>
                                                    </a>
                                                </li>
                                            <?php endfor; ?>

                                            <li
                                                class="page-item <?= ($currentPage ?? 1) >= ($totalPages ?? 1) ? 'disabled' : '' ?>">
                                                <a class="page-link"
                                                    href="?page=<?= ($currentPage ?? 1) + 1 ?><?= isset($searchQuery) ? '&search=' . urlencode($searchQuery) : '' ?>"
                                                    aria-label="Next">
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
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
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
                    <p class="text-muted mb-0">You are about to delete user <strong id="deleteUserName"></strong>. This
                        action cannot be undone.</p>
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
                    tooltipList.forEach(function (tooltip) { tooltip.hide(); });
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