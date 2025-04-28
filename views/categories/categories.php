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
    <title>Category Management</title>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    /* Table container styling */
    .table-container {
        transition: opacity 0.3s ease;
        max-height: 500px;
        overflow-y: auto;
        overflow-x: auto;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        position: relative;
        background-color: #ffffff;
    }

    .table-container.loading {
        opacity: 0.5;
        pointer-events: none;
    }

    /* Table styling */
    .category-table {
        margin-bottom: 0;
        width: 100%;
        min-width: 600px;
        border-collapse: separate;
        border-spacing: 0;
        background-color: #ffffff;
        border-radius: 8px;
        overflow: hidden;
    }

    .category-table th {
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
        position: sticky;
        top: 0;
        z-index: 1;
        text-align: center;
    }

    .category-table td {
        vertical-align: middle;
        padding: 15px 24px;
        color: #495057;
        border-bottom: 1px solid #eceff1;
        white-space: nowrap;
        transition: background-color 0.2s ease;
        text-align: center;
    }

    .category-table tbody tr:nth-child(odd) {
        background-color: #e9ecef;
    }

    .category-table tbody tr:nth-child(even) {
        background-color: #fff;
    }

    .category-table tbody tr:hover {
        background-color: #f5f7fa !important;
        box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.05);
    }

    .category-table tbody tr:last-child td {
        border-bottom: none;
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

    /* Dropdown menu */
    .dropdown-menu {
        z-index: 1000;
        min-width: 150px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    }

    .dropdown-item {
        padding: 8px 16px;
        font-size: 0.9rem;
    }

    .dropdown-item i {
        margin-right: 8px;
    }

    /* Card styling */
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        border: none;
    }

    .card-header {
        background-color: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        padding: 1rem 1.5rem;
    }

    /* Modal styling */
    .modal-content {
        border: none;
        border-radius: 12px;
    }

    .modal-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    }

    .modal-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.08);
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

    /* Search container styling */
    .search-container .input-group {
        max-width: 300px;
    }

    .search-container .form-control {
        border: 1px solid #ced4da;
        border-right: none;
        border-radius: 8px 0 0 8px;
        padding: 8px 16px;
        font-size: 0.9rem;
        box-shadow: none;
    }

    .search-container .btn-primary {
        border: 1px solid #0d6efd;
        border-left: none;
        border-radius: 0 8px 8px 0;
        background-color: #0d6efd;
        color: #fff;
        padding: 8px 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .search-container .btn-primary i {
        font-size: 1rem;
    }

    .search-container .form-control:focus {
        box-shadow: none;
        border-color: #ced4da;
    }

    .search-container .btn-primary:hover {
        background-color: #0b5ed7;
        border-color: #0b5ed7;
    }

    /* Success Message Styling - Centered over table */
    .success-message-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 100;
        pointer-events: none;
    }

    .success-message {
        background: #ffffff;
        color: #333;
        padding: 2rem 3rem;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        animation: popIn 0.5s ease-out;
        min-width: 400px;
        max-width: 90%;
        border-left: 5px solid #4caf50;
        pointer-events: auto;
    }

    .success-message .icon {
        font-size: 3rem;
        color: #4caf50;
        margin-bottom: 1rem;
        animation: bounce 0.6s ease;
    }

    .success-message .text {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 600;
        text-align: center;
        line-height: 1.4;
    }

    .success-message .btn-close {
        position: absolute;
        top: 15px;
        right: 15px;
        color: #666;
        opacity: 0.8;
        font-size: 1rem;
        padding: 0.5rem;
    }

    .success-message .btn-close:hover {
        opacity: 1;
        color: #333;
    }

    @keyframes popIn {
        0% {
            opacity: 0;
            transform: scale(0.9);
        }

        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-15px);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .success-message {
            padding: 1.5rem;
            min-width: 300px;
        }

        .success-message .icon {
            font-size: 2rem;
        }

        .success-message .text {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 576px) {
        .success-message {
            padding: 1rem;
            min-width: 250px;
        }

        .success-message .icon {
            font-size: 1.8rem;
            margin-bottom: 0.75rem;
        }

        .success-message .text {
            font-size: 1rem;
        }
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
                                <i class="fas fa-folder me-2 text-primary"></i> Category Management
                            </h4>
                            <div class="d-flex flex-wrap gap-3">
                                <!-- Search Form -->
                                <div class="search-container">
                                    <form action="/categories/search" method="GET" class="d-flex align-items-center"
                                        id="searchForm">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search for category..." id="searchInput"
                                                value="<?= htmlspecialchars($data['search_query'] ?? '') ?>">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <!-- Add Category Button -->
                                <a href="/category/create" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Create Category
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Table -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-container">
                            <?php if (isset($_SESSION['success_message'])): ?>
                            <div class="success-message-overlay">
                                <div class="success-message alert alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle icon"></i>
                                    <p class="text"><?= htmlspecialchars($_SESSION['success_message']) ?></p>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            </div>
                            <?php unset($_SESSION['success_message']); ?>
                            <?php endif; ?>

                            <table class="category-table table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">Category Name</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($data['categories']) && is_array($data['categories']) && count($data['categories']) > 0): ?>
                                    <?php foreach ($data['categories'] as $category): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($category['category_name']) ?></td>
                                        <td><?= htmlspecialchars(date('F j, Y, g:i a', strtotime($category['created_at']))) ?>
                                        </td>
                                        <td>
                                            <button class="action-btn" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false" data-bs-toggle="tooltip" title="Actions">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="/categories/category/show/<?= $category['category_id'] ?>">
                                                        <i class="fas fa-eye text-primary me-2"></i> View
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="/category/edit/<?= $category['category_id'] ?>">
                                                        <i class="fas fa-edit text-success me-2"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item text-danger"
                                                        data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"
                                                        data-categoryid="<?= $category['category_id'] ?>"
                                                        data-categoryname="<?= htmlspecialchars($category['category_name']) ?>">
                                                        <i class="fas fa-trash-alt me-2"></i> Delete
                                                    </button>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="3">
                                            <div class="empty-state">
                                                <i class="fas fa-box-open"></i>
                                                <h5>No categories found</h5>
                                                <p>
                                                    <?php if (!empty($data['search_query'])): ?>
                                                    No categories match your search criteria.
                                                    <?php else: ?>
                                                    Add a new category to get started.
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
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
                    <p class="text-muted mb-0">You are about to delete category <strong
                            id="deleteCategoryName"></strong>. This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" action="">
                        <input type="hidden" name="_token" value="<?= htmlspecialchars($csrfToken ?? '') ?>">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-2"></i>Delete Category
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>


    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                trigger: 'hover'
            });
        });

        // Handle delete modal
        const confirmDeleteModal = document.getElementById('confirmDeleteModal');
        if (confirmDeleteModal) {
            confirmDeleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const categoryId = button.getAttribute('data-categoryid');
                const categoryName = button.getAttribute('data-categoryname');

                const categoryNameElement = document.getElementById('deleteCategoryName');
                if (categoryNameElement) categoryNameElement.textContent = categoryName;

                const form = document.getElementById('deleteForm');
                if (form) form.action = "/category/delete/" + categoryId;

                // Hide tooltips when modal opens
                tooltipList.forEach(tooltip => tooltip.hide());
            });
        }

        // Search functionality (client-side filtering as fallback)
        const searchInput = document.getElementById("searchInput");
        const tableContainer = document.querySelector('.table-container');
        const tbody = document.querySelector('.category-table tbody');
        let debounceTimeout;
        const debounceDelay = 300;

        <?php if (empty($data['search_query'])): ?>

        function updateTable(filter) {
            const rows = tbody.querySelectorAll('tr');
            let hasVisibleRows = false;

            rows.forEach(row => {
                const cells = row.getElementsByTagName('td');
                let found = false;
                Array.from(cells).forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(filter.toLowerCase())) {
                        found = true;
                    }
                });
                if (found) {
                    row.style.display = '';
                    hasVisibleRows = true;
                } else {
                    row.style.display = 'none';
                }
            });

            if (!hasVisibleRows && rows.length > 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="3">
                            <div class="empty-state">
                                <i class="fas fa-box-open"></i>
                                <h5>No categories found</h5>
                                <p>No categories match your search criteria.</p>
                            </div>
                        </td>
                    </tr>
                `;
            }
        }

        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimeout);
            const query = this.value.trim();
            debounceTimeout = setTimeout(() => {
                updateTable(query);
            }, debounceDelay);
        });
        <?php endif; ?>

        // Auto-dismiss success message after 5 seconds
        const successMessage = document.querySelector('.success-message');
        if (successMessage) {
            setTimeout(() => {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(successMessage);
                if (bsAlert) bsAlert.close();
            }, 5000);
        }
    });
    </script>
</body>

</html>