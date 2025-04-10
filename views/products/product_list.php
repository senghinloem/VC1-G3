<?php
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
    <title>Product List Dashboard</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
    }

    .table-container.loading {
        opacity: 0.5;
        pointer-events: none;
    }

    /* Table styling */
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
        text-align: center;
    }

    .product-table td {
        vertical-align: middle;
        padding: 15px 24px;
        color: #495057;
        border-bottom: 1px solid #eceff1;
        white-space: nowrap;
        transition: background-color 0.2s ease;
        text-align: center;
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

    .product-table tbody tr:last-child td {
        border-bottom: none;
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

    /* Search loading state */
    .search-container .spinner {
        display: none;
        margin-left: 10px;
        color: #0d6efd;
    }

    .search-container.loading .spinner {
        display: inline-block;
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
                                <i class="fas fa-cogs me-2 text-primary"></i> Product List
                            </h4>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="search-container">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input type="text" id="searchInput" class="form-control"
                                                value="<?= htmlspecialchars($searchQuery ?? '') ?>"
                                                placeholder="Search product... " onkeyup="searchFAQs()">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                        <th>Product ID</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Unit</th>
                                        <th>Stock ID</th>
                                        <th>Stock Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($products) && is_array($products)): ?>
                                    <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($product['product_id']) ?></td>
                                        <td><?= htmlspecialchars($product['product_name']) ?></td>
                                        <td>$<?= number_format((float)$product['price'], 2) ?></td>
                                        <td><?= htmlspecialchars($product['unit']) ?></td>
                                        <td><?= htmlspecialchars($product['stock_id'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($product['stock_name'] ?? 'N/A') ?></td>
                                        <td>
                                            <button class="action-btn" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false" data-bs-toggle="tooltip" title="Actions">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="/product_list/edit/<?= $product['product_id'] ?>">
                                                        <i class="fas fa-edit text-success me-2"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item text-danger"
                                                        data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"
                                                        data-productid="<?= $product['product_id'] ?>"
                                                        data-productname="<?= htmlspecialchars($product['product_name']) ?>">
                                                        <i class="fas fa-trash-alt me-2"></i> Delete
                                                    </button>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="7">
                                            <div class="empty-state">
                                                <i class="fas fa-box-open"></i>
                                                <h5>No products found</h5>
                                                <p>No products match your criteria or none have been added yet.</p>
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
                    <p class="text-muted mb-0">You are about to delete product <strong id="deleteProductName"></strong>.
                        This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" action="">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-2"></i>Delete Product
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                const productId = button.getAttribute('data-productid');
                const productName = button.getAttribute('data-productname');

                document.getElementById('deleteProductName').textContent = productName;
                document.getElementById('deleteForm').action = "/product_list/destroy/" + productId;
            });

            confirmDeleteModal.addEventListener('show.bs.modal', function() {
                tooltipList.forEach(tooltip => tooltip.hide());
            });
        }

        // Enhanced Search functionality
        const searchInput = document.getElementById('searchInput');
        const tableContainer = document.querySelector('.table-container');
        const tbody = document.querySelector('.product-table tbody');
        const searchContainer = document.querySelector('.search-container');
        let debounceTimeout;
        let lastQuery = '';
        const debounceDelay = 300;

        async function performSearch(query) {
            try {
                searchContainer.classList.add('loading');
                tableContainer.classList.add('loading');

                const response = await fetch(`/product_list/search?q=${encodeURIComponent(query)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                updateTable(data.products);
            } catch (error) {
                console.error('Search error:', error);
                showErrorState();
            } finally {
                searchContainer.classList.remove('loading');
                tableContainer.classList.remove('loading');
            }
        }

        function updateTable(products) {
            tbody.innerHTML = '';

            if (!products || products.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-box-open"></i>
                                <h5>No products found</h5>
                                <p>No products match your search criteria.</p>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            products.forEach(product => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${escapeHtml(product.product_id)}</td>
                    <td>${escapeHtml(product.product_name)}</td>
                    <td>$${Number(product.price).toFixed(2)}</td>
                    <td>${escapeHtml(product.unit)}</td>
                    <td>${escapeHtml(product.stock_id || '')}</td>
                    <td>${escapeHtml(product.stock_name || 'N/A')}</td>
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
                                <a class="dropdown-item" href="/product_list/edit/${product.product_id}">
                                    <i class="fas fa-edit text-success me-2"></i> Edit
                                </a>
                            </li>
                            <li>
                                <button type="button" 
                                        class="dropdown-item text-danger" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#confirmDeleteModal" 
                                        data-productid="${product.product_id}" 
                                        data-productname="${escapeHtml(product.product_name)}">
                                    <i class="fas fa-trash-alt me-2"></i> Delete
                                </button>
                            </li>
                        </ul>
                    </td>
                `;
                tbody.appendChild(row);
            });

            const newTooltips = [].slice.call(tbody.querySelectorAll('[data-bs-toggle="tooltip"]'));
            newTooltips.forEach(el => new bootstrap.Tooltip(el, {
                trigger: 'hover'
            }));
        }

        function showErrorState() {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fas fa-exclamation-triangle text-danger"></i>
                            <h5>Search Error</h5>
                            <p>Something went wrong. Please try again.</p>
                        </div>
                    </td>
                </tr>
            `;
        }

        function escapeHtml(unsafe) {
            return (unsafe || '')
                .toString()
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            if (query === lastQuery) return;

            clearTimeout(debounceTimeout);

            if (query.length === 0 || query.length >= 1) {
                debounceTimeout = setTimeout(() => {
                    lastQuery = query;
                    performSearch(query);
                }, debounceDelay);
            }
        });

        searchInput.addEventListener('change', function() {
            if (this.value.trim() === '' && lastQuery !== '') {
                lastQuery = '';
                performSearch('');
            }
        });

        function resetLoadingStates() {
            searchContainer.classList.remove('loading');
            tableContainer.classList.remove('loading');
        }

        window.addEventListener('load', resetLoadingStates);
        window.addEventListener('pageshow', resetLoadingStates);
        resetLoadingStates();
    });
    </script>
</body>

</html>