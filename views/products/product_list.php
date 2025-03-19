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
    <title>Product List</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .table-container {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .dropdown-toggle::after {
            display: none;
        }

        .dropdown-menu {
            min-width: 150px;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .table-responsive {
            max-height: 500px;
            overflow-y: auto;
        }

        table {
            width: 100%;
        }

        table tbody {
            display: block;
            max-height: 320px;
            overflow-y: auto;
        }

        table thead, table tbody tr {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        thead th {
            position: sticky;
            top: 0;
            background-color: #007bff;
            color: #fff;
            z-index: 1;
        }

        tbody tr {
            display: table-row;
        }

        .dropdown-toggle {
            border: none;
            background: transparent;
            padding: 0;
            box-shadow: none;
        }

        .dropdown-toggle:focus {
            outline: none;
        }

    </style>
</head>
<body>
<div class="container mt-3 mb-3">
    <!-- Product List Card -->
    <div class="table-container">
        <!-- Title, Search Bar, and Add Product Button -->
        <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
            <h4 class="mb-0"><i class="fas fa-cogs"></i> Product List</h4>

            <!-- Search Bar -->
            <form action="/product_list/search" method="GET" class="d-flex">
                <div class="input-group" style="width: 400px;">
                    <input type="text" name="q" class="form-control" placeholder="Search for products" value="<?= htmlspecialchars($searchQuery ?? '') ?>">
                    <span class="input-group-text btn-primary btn"><i class="fas fa-search"></i></span>
                </div>
            </form>

        </div>

        <!-- Product Stock Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-secondary">
                    <tr>
                        <th class="text-white">Product ID</th>
                        <th class="text-white">Product Name</th>
                        <th class="text-white">Price</th>
                        <th class="text-white">Unit</th>
                        <th class="text-white">Stock ID</th>
                        <th class="text-white">Stock Name</th>
                        <th class="text-center text-white">Actions</th>
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
    <!-- Action Dropdown -->
    <div class="dropdown">
        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton<?= $product['product_id'] ?>" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-ellipsis-v"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton<?= $product['product_id'] ?>">
            <li>
                <a class="dropdown-item text-primary" href="/product_list/edit/<?= $product['product_id'] ?>">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </li>
            <li>
                <!-- Button to trigger modal -->
                <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" 
                        data-productid="<?= $product['product_id'] ?>">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </li>
        </ul>
    </div>
</td>

<!-- Bootstrap Delete Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <form id="deleteForm" method="POST">
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to Update Form Action -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var confirmDeleteModal = document.getElementById('confirmDeleteModal');
        confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var productId = button.getAttribute('data-productid'); // Extract product ID
            var form = document.getElementById('deleteForm');
            form.action = "/product_list/destroy/" + productId; // Update form action dynamically
        });
    });
</script>

                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No products found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
