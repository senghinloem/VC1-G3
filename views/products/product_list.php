<<<<<<< HEAD
<main class="app-main mt-3">
    <div class="container">
        <h2 class="mb-4">Product List</h2>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="/product_list/create_list" class="btn btn-success px-4 py-2 shadow-sm">+ Add Product</a>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover custom-table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="text-center">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col" class="text-center">Available</th>
                        <th scope="col" class="text-center">Price</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($product_list) && is_array($product_list)): ?>
                        <?php foreach ($product_list as $list): ?>
                            <tr>
                                <td class="text-center">
                                    <img src="<?= $list['image'] ?>" alt="Product Image" class="product-img">
                                </td>
                                <td><?= $list['name']?></td>
                                <td class="text-center"><?= $list['available_quantity'] ?></td>
                                <td class="text-center">$<?= number_format($list['price'], 2) ?></td>
                                <td class="text-center">
                                    <a href="" class="btn btn-outline-info btn-sm"><i class="fas fa-eye"></i></a>
                                    <a href="/product_list/edit/<?= $list['product_list_id']?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i></a>
                                    <form action="/product_list/destroy/<?= $list['product_list_id']?>" method="POST" style="display:inline;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">No products available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Improved CSS -->
<style>
    .custom-table {
        background-color: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .thead-dark {
        background-color: #343a40;
        color: #fff;
    }

    .product-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .product-img:hover {
        transform: scale(1.1);
    }

    .btn-sm {
        font-size: 14px;
        padding: 6px 12px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-outline-info:hover, 
    .btn-outline-primary:hover, 
    .btn-outline-danger:hover {
        color: #fff;
        transform: scale(1.05);
    }
    .btn-sm i {
    transition: color 0.3s ease;
}

.btn-outline-info:hover i, 
.btn-outline-primary:hover i, 
.btn-outline-danger:hover i {
    color: #fff !important;
}

</style>


=======
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
    </style>
</head>
<body>

<div class="container">
    
    <div class="card p-4">
    <h2>Product List</h2>
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
                                <td>
                                    <div class="action-buttons">
                                        <a href="/product_list/view/<?= $list['product_list_id'] ?>" class="text-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="/product_list/edit/<?= $list['product_list_id'] ?>" class="text-secondary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="/product_list/destroy/<?= $list['product_list_id'] ?>" method="POST" style="display:inline;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="text-danger border-0 bg-transparent"
                                                onclick="return confirm('Are you sure you want to delete this product?');" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
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
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
>>>>>>> feature/product_list
