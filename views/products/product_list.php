<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: /");
    exit;
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
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 30px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .search-bar input {
            border-radius: 25px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.12);
        }

        table {
            width: 80%; /* Reduce width */
            font-size: 12px; /* Smaller text */
            margin: auto; /* Center the table */
        }

        table th, table td {
            padding: 5px; /* Reduce padding */
            white-space: nowrap; /* Prevent wrapping */
        }

        table th {
            background-color: #f8f9fa; /* Light gray background */
            font-weight: bold;
        }

        .search-bar button {
            border-radius: 50%;
            background-color: #007bff;
            color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
        .table th {
            background-color: #f1f1f1;
            color: #007bff;
        }
        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
        .action-buttons a {
            font-size: 16px;
            margin: 0 5px;
            transition: transform 0.3s ease;
        }
        .action-buttons a:hover {
            transform: scale(1.1);
        }
        .action-buttons .text-danger {
            color: #dc3545 !important;
        }
        .action-buttons .text-primary {
            color: #007bff !important;
        }
        .action-buttons .text-secondary {
            color: #6c757d !important;
        }
        .add-product-btn {
            border-radius: 30px;
            font-size: 16px;
        }
        .add-product-btn i {
            margin-right: 5px;
        }

        .table-container {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .dropdown-toggle::after {
            display: none;
        }
        .dropdown-menu {
            min-width: 120px;
        }
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card p-4">
        <h2>Product Lists</h2>
        <!-- Row for Search Bar and Product List -->
        <div class="row justify-content-between align-items-center mt-4 mb-4">
            <!-- Search Bar -->
            <div class="col-md-6">
                <form action="/product_list/search" method="GET" class="search-bar d-flex">
                    <input type="text" name="q" value="<?= isset($searchQuery) ? htmlspecialchars($searchQuery) : ''; ?>" 
                        placeholder="Search products..." class="form-control shadow-sm">
                    <button type="submit" class="btn btn-primary px-4 ms-2"><i class="fas fa-search"></i></button>
                </form>
            </div>

            <!-- Add Product Button -->
            <div class="col-md-3 text-end">
                <a href="/product_list/create_list" class="btn btn-success add-product-btn"><i class="fas fa-plus"></i> Add Product</a>
            </div>
        </div>

        <!-- Product Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Available</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($product_list) && is_array($product_list)): ?>
                        <?php foreach ($product_list as $list): ?>
                            <tr>
                                <td><img src="<?= htmlspecialchars($list['image']) ?>" alt="Product Image" class="product-img"></td>
                                <td><?= htmlspecialchars($list['name']) ?></td>
                                <td><?= (int)$list['available_quantity'] ?></td>
                                <td>$<?= number_format((float)$list['price'], 2) ?></td>
                                <td class="text-center">
    <!-- Action Dropdown -->
    <div class="dropdown">
        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton<?= $list['product_list_id'] ?>" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-ellipsis-v"></i> <!-- Three-dot icon -->
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton<?= $list['product_list_id'] ?>">
            <li>
                <a class="dropdown-item" href="/product_list/view/<?= $list['product_list_id'] ?>">
                    <i class="fas fa-eye text-primary me-2"></i> View
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="/product_list/edit/<?= $list['product_list_id'] ?>">
                    <i class="fas fa-edit text-secondary me-2"></i> Edit
                </a>
            </li>
            <li>
                <a class="dropdown-item text-danger" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $list['product_list_id'] ?>">
                    <i class="fas fa-trash me-2"></i> Delete
                </a>
            </li>
        </ul>
    </div>
</td>

<!-- Modal for Deletion -->
<!-- Modal for Deletion -->
<div class="modal fade" id="deleteModal<?= $list['product_list_id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $list['product_list_id'] ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p>Do you want to delete this product?</p>
            </div>
            <div class="modal-footer">
                <form action="/product_list/destroy/<?= $list['product_list_id'] ?>" method="POST" class="d-inline">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">No products available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Product Stock Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Unit</th>
                        <th>Stock ID</th>
                        <th>Stock Name</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>             
                    <?php if (!empty($product_stock_list) && is_array($product_stock_list)): ?>
                        <?php foreach ($product_stock_list as $stock): ?>
                            <tr>
                                <td><?= htmlspecialchars($stock['product_id']) ?></td>
                                <td><?= htmlspecialchars($stock['product_name']) ?></td>
                                <td>$<?= number_format((float)$stock['price'], 2) ?></td>
                                <td><?= htmlspecialchars($stock['unit']) ?></td>
                                <td><?= htmlspecialchars($stock['stock_id']) ?></td>
                                <td><?= htmlspecialchars($stock['stock_name']) ?></td>
                                <td><?= (int)$stock['quantity'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No stock data available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Success & Error Alert Messages -->
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['success']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $_SESSION['error']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
