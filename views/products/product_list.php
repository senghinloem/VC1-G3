<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: /dashboard");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Arial', sans-serif; }
        .container { margin-top: 30px; }
        .card { border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .card-header { background-color: #007bff; color: #fff; border-top-left-radius: 10px; border-top-right-radius: 10px; }
        .search-bar input { border-radius: 25px; box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.12); }
        
        /* Scrollable table container */
        .table-container {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        /* Scrollable table */
        .table-responsive {
            max-height: 400px; /* Set table height limit */
            overflow-y: auto;
        }

        /* Fix table header */
        .table thead th {
            position: sticky;
            top: 0;
            background-color: #f1f1f1;
            color: #007bff;
            z-index: 2;
        }

        /* Adjust scrollbar */
        .table-responsive::-webkit-scrollbar {
            width: 8px;
        }
        .table-responsive::-webkit-scrollbar-thumb {
            background-color: #007bff;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card p-4">
        <h2>Product List</h2>

        <!-- Search Bar -->
        <div class="row justify-content-between align-items-center mt-4 mb-4">
            <div class="col-md-6">
                <form action="/product_list/search" method="GET" class="search-bar d-flex">
                    <input type="text" name="q" value="<?= isset($searchQuery) ? htmlspecialchars($searchQuery) : ''; ?>" 
                        placeholder="Search products..." class="form-control shadow-sm">
                    <button type="submit" class="btn btn-primary px-4 ms-2"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>

        <!-- Product Stock Table -->
        <div class="table-container">
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
                        <?php if (!empty($products) && is_array($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?= htmlspecialchars($product['product_id']) ?></td>
                                    <td><?= htmlspecialchars($product['product_name']) ?></td>
                                    <td>$<?= number_format((float)$product['price'], 2) ?></td>
                                    <td><?= htmlspecialchars($product['unit']) ?></td>
                                    <td><?= htmlspecialchars($product['stock_id'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($product['stock_name'] ?? 'N/A') ?></td>
                                    <td><?= (int)$product['quantity'] ?></td>
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
</div>

<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
