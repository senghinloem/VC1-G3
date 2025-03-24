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
    <title>Product Management</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --danger: #e74c3c;
            --success: #2ecc71;
            --light: #ecf0f1;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }

        .card-container {
            background: #ffffff;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin: 2rem auto;
            max-width: 1200px;
        }

        .header-section {
            background: var(--primary);
            color: white;
            padding: 1.5rem;
            border-radius: 15px 15px 0 0;
            margin: -2rem -2rem 2rem;
        }

        .search-container {
            position: relative;
            max-width: 500px;
        }

        .search-container input {
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .search-container input:focus {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            outline: none;
        }

        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
            background: white;
        }

        thead th {
            background: var(--secondary);
            color: white;
            padding: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tbody tr {
            transition: all 0.3s ease;
        }

        tbody tr:hover {
            background: var(--light);
            transform: translateY(-2px);
        }

        /* New Action Menu Styles */
        .action-menu {
            position: relative;
            display: inline-block;
        }

        .action-toggle {
            background: var(--secondary);
            color: white;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .action-toggle:hover {
            background: var(--primary);
            transform: rotate(90deg);
        }

        .action-options {
            position: absolute;
            right: 0;
            top: 100%;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            min-width: 120px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
            z-index: 10;
        }

        .action-menu:hover .action-options {
            opacity: 1;
            visibility: visible;
            transform: translateY(5px);
        }

        .action-item {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            color: var(--primary);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .action-item:hover {
            background: var(--light);
            color: var(--secondary);
        }

        .action-item.danger {
            color: var(--danger);
        }

        .action-item i {
            margin-right: 0.5rem;
        }

        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: var(--danger);
            color: white;
            border-radius: 15px 15px 0 0;
        }

        .btn-custom {
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
<div class="container card-container">
    <!-- Header Section -->
    <div class="header-section">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="fas fa-cubes me-2"></i> Product List</h3>
            <form action="/product_list/search" method="GET" class="search-container">
                <input type="text" name="q" class="form-control" 
                       placeholder="Search products..." 
                       value="<?= htmlspecialchars($searchQuery ?? '') ?>">
            </form>
        </div>
    </div>

    <!-- Product Table -->
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Unit</th>
                    <th>Stock ID</th>
                    <th>Stock Name</th>
                    <th class="text-center">Actions</th>
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
                            <td class="text-center">
                                <div class="action-menu">
                                    <button class="action-toggle">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="action-options">
                                        <a href="/product_list/edit/<?= $product['product_id'] ?>" 
                                           class="action-item">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button class="action-item danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#confirmDeleteModal"
                                                data-productid="<?= $product['product_id'] ?>">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-box-open me-2"></i> No products found
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
                <h5 class="modal-title" id="confirmDeleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i> Confirm Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-custom" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cancel
                </button>
                <form id="deleteForm" method="POST">
                    <button type="submit" class="btn btn-danger btn-custom">
                        <i class="fas fa-trash me-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Custom Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var confirmDeleteModal = document.getElementById('confirmDeleteModal');
        confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var productId = button.getAttribute('data-productid');
            var form = document.getElementById('deleteForm');
            form.action = "/product_list/destroy/" + productId;
        });
    });
</script>
</body>
</html>