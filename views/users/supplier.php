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
        /* Style the action button to match your friend's code */
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

        /* Ensure the dropdown menu is visible */
        .dropdown-menu {
            z-index: 1000; /* Ensure it appears above other elements */
            min-width: 120px; /* Match your friend's dropdown width */
        }

        /* Style the table to match your friend's design */
        .supplier-table {
            margin-bottom: 0;
            width: 100%;
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
        }

        .supplier-table td {
            vertical-align: middle;
            padding: 5px 5px;
            color: #495057;
            border-bottom: 1px solid #eceff1;
            white-space: nowrap;
            transition: background-color 0.2s ease;
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
<body>

    <div class="container mt-4" id="supplierListView">
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

        <div class="table-responsive">
            <table class="supplier-table table-borderless">
                <thead class="table-secondary">
                    <tr>
                        <th scope="col">Supplier ID</th>
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
                                <td><?= htmlspecialchars($supplier['supplier_id']) ?></td>
                                <td><?= htmlspecialchars($supplier['supplier_name']) ?></td>
                                <td><?= htmlspecialchars($supplier['email']) ?></td>
                                <td><?= htmlspecialchars($supplier['phone']) ?></td>
                                <td><?= htmlspecialchars($supplier['address']) ?></td>
                                <td><?= htmlspecialchars($supplier['created_at']) ?></td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="action-btn dropdown-toggle" type="button" 
                                                id="dropdownMenuButton-<?= $supplier['supplier_id'] ?>" 
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false"
                                                aria-label="More actions">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" 
                                            aria-labelledby="dropdownMenuButton-<?= $supplier['supplier_id'] ?>">
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
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">
                                <div class="empty-state">
                                    <i class="fas fa-box-open fa-3x text-muted"></i>
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

    <!-- Bootstrap JS (Local Copy) -->
    <!-- Replace 'js/bootstrap.bundle.min.js' with the actual path to your local file -->
    <script src="js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Test if Bootstrap is loaded
            if (typeof bootstrap === 'undefined') {
                console.error('Bootstrap JavaScript is not loaded. Please check the script tag and ensure the file path is correct.');
            } else {
                console.log('Bootstrap JavaScript is loaded successfully.');

                // Manually initialize dropdowns to ensure they work
                const dropdownElementList = document.querySelectorAll('.dropdown-toggle');
                dropdownElementList.forEach(dropdownToggleEl => {
                    new bootstrap.Dropdown(dropdownToggleEl);
                });
            }

            // Debug: Log when the dropdown button is clicked
            const dropdownButtons = document.querySelectorAll('.dropdown-toggle');
            dropdownButtons.forEach(button => {
                button.addEventListener('click', () => {
                    console.log('Dropdown button clicked:', button.id);
                });
            });

            // Debug: Log when the dropdown menu is shown or hidden
            const dropdowns = document.querySelectorAll('.dropdown');
            dropdowns.forEach(dropdown => {
                dropdown.addEventListener('show.bs.dropdown', () => {
                    console.log('Dropdown menu is being shown for:', dropdown.querySelector('.dropdown-toggle').id);
                });
                dropdown.addEventListener('hide.bs.dropdown', () => {
                    console.log('Dropdown menu is being hidden for:', dropdown.querySelector('.dropdown-toggle').id);
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
                });
            }

            // Search functionality
            const searchInput = document.getElementById("searchInput");
            if (searchInput) {
                searchInput.addEventListener("keyup", function() {
                    let filter = this.value.toLowerCase();
                    let rows = document.querySelectorAll("tbody tr");
                
                    rows.forEach(row => {
                        let supplierID = row.cells[0].textContent.toLowerCase();
                        let supplierName = row.cells[1].textContent.toLowerCase();
                        let email = row.cells[2].textContent.toLowerCase();
                        let phone = row.cells[3].textContent.toLowerCase();
                        let address = row.cells[4].textContent.toLowerCase();
                        let createdAt = row.cells[5].textContent.toLowerCase();

                        row.style.display = supplierID.includes(filter) || supplierName.includes(filter) || email.includes(filter) || phone.includes(filter) || address.includes(filter) || createdAt.includes(filter) ? "" : "none";
                    });
                });
            }
        });
    </script>

</body>
</html>
