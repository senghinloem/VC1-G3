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
    <title>Supplier Management</title>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Table container styling (matching Product List) */
        .table-container {
            transition: opacity 0.3s ease;
            max-height: 500px;
            overflow-y: auto;
            overflow-x: auto;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .table-container.loading {
            opacity: 0.5;
            pointer-events: none;
        }

        /* Table styling (matching Product List) */
        .supplier-table {
            margin-bottom: 0;
            width: 100%;
            min-width: 800px;
            border-collapse: separate;
            border-spacing: 0;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }

        .supplier-table th {
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
            background-color: #f8f9fa;
            text-align: center;
        }

        .supplier-table td {
            vertical-align: middle;
            padding: 15px 24px;
            color: #495057;
            border-bottom: 1px solid #eceff1;
            white-space: nowrap;
            transition: background-color 0.2s ease;
            text-align: center;
        }

        .supplier-table tbody tr:nth-child(odd) {
            background-color: #e9ecef;
        }

        .supplier-table tbody tr:nth-child(even) {
            background-color: #fff;
        }

        .supplier-table tbody tr:hover {
            background-color: #f5f7fa !important;
            box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.05);
        }

        .supplier-table tbody tr:last-child td {
            border-bottom: none;
        }

        .supplier-table tbody tr td[colspan="6"] {
            background-color: transparent;
        }

        /* Action buttons (matching Product List) */
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

        /* Ensure the dropdown menu is visible and styled consistently */
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

        /* Card styling (matching Product List) */
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

        /* Modal styling (already matching, but ensuring consistency) */
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

        /* Empty state (matching Product List) */
        .empty-state {
            text-align: center;
            padding: 40px 0;
        }

        .empty-state i {
            font-size: 3rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }

    </style>
</head>

<body class="bg-light">

    <div class="container-fluid py-4" id="supplierListView">
        <!-- Header Card -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <h4 class="mb-0 d-flex align-items-center">
                            <i class="fas fa-truck me-2 text-primary"></i> Suppliers Management
                        </h4>
                        <div class="d-flex flex-wrap gap-3">
                            <!-- Search Form -->
                            <div class="search-container">
                                <form action="/suppliers/search" method="GET" class="d-flex align-items-center" id="searchForm">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="fas fa-search text-muted"></i>
                                        </span>
                                        <input type="text" name="search" class="form-control border-start-0" 
                                               placeholder="Search for supplier..." 
                                               id="searchInput">

                                    </div>
                                </form>
                            </div>
                            <!-- Add Supplier Button -->
                            <a href="/supplier/create" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Create Supplier
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Supplier Table -->
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-container">
                        <table class="supplier-table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col">Supplier Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($suppliers) && is_array($suppliers)): ?>
                                    <?php foreach ($suppliers as $supplier): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($supplier['supplier_name']) ?></td>
                                            <td><?= htmlspecialchars($supplier['email']) ?></td>
                                            <td><?= htmlspecialchars($supplier['phone']) ?></td>
                                            <td><?= htmlspecialchars($supplier['address']) ?></td>
                                            <td><?= htmlspecialchars($supplier['created_at']) ?></td>
                                            <td>
                                                <button class="action-btn" type="button" 
                                                        data-bs-toggle="dropdown" 
                                                        aria-expanded="false"
                                                        data-bs-toggle="tooltip" 
                                                        title="Actions">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="/supplier/detail/<?= $supplier['supplier_id'] ?>">
                                                            <i class="fas fa-eye text-primary me-2"></i> Detail
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="/supplier/edit/<?= $supplier['supplier_id'] ?>">
                                                            <i class="fas fa-edit text-success me-2"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button type="button" 
                                                                class="dropdown-item text-danger" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#confirmDeleteModal" 
                                                                data-supplierid="<?= $supplier['supplier_id'] ?>" 
                                                                data-suppliername="<?= htmlspecialchars($supplier['supplier_name']) ?>">
                                                            <i class="fas fa-trash-alt me-2"></i> Delete
                                                        </button>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6">
                                            <div class="empty-state">
                                                <i class="fas fa-box-open"></i>
                                                <h5>No suppliers found</h5>
                                                <p>Add a new supplier to get started.</p>
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

    <!-- In your HTML body, keep your existing success alert container -->
<div class="col-12">
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show alert-slide" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= htmlspecialchars($_SESSION['success_message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
</div>

<!-- Delete Confirmation Modal (unchanged) -->
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
                <p class="text-muted mb-0">You are about to delete supplier <strong id="deleteSupplierName"></strong>. This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" action="">
                    <input type="hidden" name="_token" value="<?= htmlspecialchars($csrfToken ?? '') ?>">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-2"></i>Delete Supplier
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Confirmation Modal -->
<div class="modal fade" id="confirmEditModal" tabindex="-1" aria-labelledby="confirmEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmEditModalLabel">Confirm Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-3">
                    <i class="fas fa-edit text-primary fa-3x"></i>
                </div>
                <h5 class="mb-2">Are you sure?</h5>
                <p class="text-muted mb-0">
                    You are about to edit supplier <strong id="editSupplierName"></strong>. 
                    Please confirm your changes before proceeding.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="editForm" method="POST" action="">
                    <input type="hidden" name="_token" value="<?= htmlspecialchars($csrfToken ?? '') ?>">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

    

<script>
document.addEventListener('DOMContentLoaded', function () {
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
        confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const supplierId = button.getAttribute('data-supplierid');
            const supplierName = button.getAttribute('data-suppliername');
            
            const supplierNameElement = document.getElementById('deleteSupplierName');
            if (supplierNameElement) supplierNameElement.textContent = supplierName;
            
            const form = document.getElementById('deleteForm');
            if (form) form.action = "/supplier/destroy/" + supplierId;

            // Hide tooltips when modal opens
            tooltipList.forEach(tooltip => tooltip.hide());
        });
    }

    // Handle edit modal
    const confirmEditModal = document.getElementById('confirmEditModal');
    if (confirmEditModal) {
        confirmEditModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const supplierId = button.getAttribute('data-supplierid');
            const supplierName = button.getAttribute('data-suppliername');
            
            const supplierNameElement = document.getElementById('editSupplierName');
            if (supplierNameElement) supplierNameElement.textContent = supplierName;
            
            const form = document.getElementById('editForm');
            if (form) form.action = "/supplier/update/" + supplierId; // Changed to update route

            // Hide tooltips when modal opens
            tooltipList.forEach(tooltip => tooltip.hide());
        });
    }

    // Search functionality
    const searchInput = document.getElementById("searchInput");
    const tableContainer = document.querySelector('.table-container');
    const tbody = document.querySelector('.supplier-table tbody');
    let debounceTimeout;
    const debounceDelay = 300;

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

        // If no rows are visible, show empty state
        if (!hasVisibleRows && rows.length > 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="fas fa-box-open"></i>
                            <h5>No suppliers found</h5>
                            <p>No suppliers match your search criteria.</p>
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

    searchInput.addEventListener('change', function() {
        if (this.value.trim() === '') {
            updateTable('');
        }
    });

    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            if (bsAlert) bsAlert.close();
        }, 5000);
    });
});
</script>

</body>
</html>
