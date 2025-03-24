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
    <title>Product Management Dashboard</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Reuse styles from User Management with adjustments for products */
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

        .product-table {
            margin-bottom: 0;
            width: 100%;
            min-width: 800px;
            border-collapse: separate;
            border-spacing: 0;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }

        .product-table th {
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
        }

        .product-table td {
            vertical-align: middle;
            padding: 5px 5px;
            color: #495057;
            border-bottom: 1px solid #eceff1;
            white-space: nowrap;
            transition: background-color 0.2s ease;
        }

        table.product-table tbody tr:nth-child(odd) {
            background-color: #e9ecef;
        }

        table.product-table tbody tr:nth-child(even) {
            background-color: #fff;
        }

        table.product-table tbody tr:hover {
            background-color: #f5f7fa !important;
            box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.05);
        }

        table.product-table tbody tr td[colspan="7"] {
            background-color: transparent;
        }

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

        .product-table tbody tr:last-child td {
            border-bottom: none;
        }

        @media (max-width: 768px) {
            .product-table th,
            .product-table td {
                padding: 14px 12px;
            }

            .action-btn {
                padding: 0.3rem 0.7rem;
                font-size: 1rem;
            }
        }

        .search-container .spinner {
            display: none;
            margin-left: 10px;
            color: #0d6efd;
        }

        .search-container.loading .spinner {
            display: inline-block;
        }

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

        .stat-card.total-products {
            background-color: #e3f2fd;
        }

        .stat-card.in-stock {
            background-color: #e8f5e9;
        }

        .stat-card.out-of-stock {
            background-color: #ffebee;
        }

        .stat-card.avg-price {
            background-color: #fff8e1;
        }

        .empty-state {
            text-align: center;
            padding: 40px 0;
        }

        .empty-state i {
            font-size: 3rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }

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
                                <i class="fas fa-cubes me-2 text-primary"></i> Product Management
                            </h4>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="search-container">
                                    <form action="/product_list/search" method="GET" class="d-flex align-items-center" id="searchForm">
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0">
                                                <i class="fas fa-search text-muted"></i>
                                            </span>
                                            <input type="text" name="q" class="form-control border-start-0" 
                                                   placeholder="Search products..." 
                                                   value="<?= htmlspecialchars($searchQuery ?? '') ?>" 
                                                   id="searchInput">
                                        </div>
                                        <i class="fas fa-spinner fa-spin spinner ms-2"></i>
                                    </form>
                                </div>
                                <a href="/product_list/create" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add Product
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Stat Cards -->
            <div class="col-12 mb-4">
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="stat-card total-products">
                            <h3><?= number_format($totalProducts ?? 0) ?></h3>
                            <p>Total Products</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="stat-card in-stock">
                            <h3><?= number_format($inStock ?? 0) ?></h3>
                            <p>In Stock</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="stat-card out-of-stock">
                            <h3><?= number_format($outOfStock ?? 0) ?></h3>
                            <p>Out of Stock</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="stat-card avg-price">
                            <h3>$<?= number_format($avgPrice ?? 0, 2) ?></h3>
                            <p>Avg. Price</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Product Table -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-container">
                            <table class="product-table table-borderless">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center">Stock ID</th>
                                        <th class="text-center">Stock Name</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($products)): ?>
                                        <tr>
                                            <td colspan="7">
                                                <div class="empty-state">
                                                    <i class="fas fa-box-open"></i>
                                                    <h5>No products found</h5>
                                                    <p>No products match your criteria or none have been added yet.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($products as $product): ?>
                                            <tr>
                                                <td class="text-center"><?= htmlspecialchars($product['product_id']) ?></td>
                                                <td class="text-center"><?= htmlspecialchars($product['product_name']) ?></td>
                                                <td class="text-center">$<?= number_format((float)$product['price'], 2) ?></td>
                                                <td class="text-center"><?= htmlspecialchars($product['unit']) ?></td>
                                                <td class="text-center"><?= htmlspecialchars($product['stock_id'] ?? 'N/A') ?></td>
                                                <td class="text-center"><?= htmlspecialchars($product['stock_name'] ?? 'N/A') ?></td>
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
                                                            <a class="dropdown-item" href="/product_list/edit/<?= $product['product_id'] ?>">
                                                                <i class="fas fa-edit text-success me-2"></i> Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <button type="button" 
                                                                    class="dropdown-item text-danger" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#confirmDeleteModal" 
                                                                    data-productid="<?= $product['product_id'] ?>" 
                                                                    data-productname="<?= htmlspecialchars($product['product_name']) ?>">
                                                                <i class="fas fa-trash-alt me-2"></i> Delete
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
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
                    <p class="text-muted mb-0">You are about to delete product <strong id="deleteProductName"></strong>. This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-2"></i>Delete Product
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, { trigger: 'hover' });
            });

            // Handle delete modal
            var confirmDeleteModal = document.getElementById('confirmDeleteModal');
            if (confirmDeleteModal) {
                confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;
                    var productId = button.getAttribute('data-productid');
                    var productName = button.getAttribute('data-productname');
                    
                    var productNameElement = document.getElementById('deleteProductName');
                    if (productNameElement) productNameElement.textContent = productName;
                    
                    var form = document.getElementById('deleteForm');
                    if (form) form.action = "/product_list/destroy/" + productId;
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

            function resetLoadingStates() {
                searchContainer.classList.remove('loading');
                tableContainer.classList.remove('loading');
            }

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

            window.addEventListener('load', resetLoadingStates);
            window.addEventListener('pageshow', resetLoadingStates);
            resetLoadingStates();
        });
    </script>
</body>
</html>