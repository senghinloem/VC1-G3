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
    <title>Supplier Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            line-height: 1.5;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 0 15px;
        }

        .card {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            padding: 15px 20px;
            background: #007bff;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h5 {
            font-size: 1.25rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-edit {
            background: #fff;
            color: #007bff;
        }

        .btn-back {
            background: #f0f0f0;
            color: #333;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            padding: 20px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .info-label {
            font-size: 0.85rem;
            color: #666;
        }

        .info-value {
            font-size: 1rem;
            font-weight: 500;
        }

        .products-section {
            padding: 20px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .product-count {
            background: #e7f3ff;
            color: #007bff;
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 0.85rem;
        }

        .table-container {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow-x: auto;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
        }

        .products-table th,
        .products-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
            font-size: 0.9rem;
        }

        .products-table th {
            background: #f9f9f9;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.8rem;
        }

        .stock-badge {
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 0.85rem;
        }

        .stock-badge.in-stock {
            background: #e6f4ea;
            color: #28a745;
        }

        .stock-badge.out-of-stock {
            background: #f8e1e9;
            color: #dc3545;
        }

        .empty-state {
            text-align: center;
            padding: 30px;
        }

        .empty-state i {
            font-size: 2rem;
            color: #ccc;
            margin-bottom: 10px;
        }

        .empty-state h5 {
            font-size: 1rem;
            color: #666;
            margin-bottom: 5px;
        }

        .empty-state p {
            font-size: 0.9rem;
            color: #888;
        }

        .footer {
            padding: 20px;
            text-align: right;
        }

        @media (max-width: 768px) {
            .container {
                margin: 10px;
                padding: 0 10px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .products-table th,
            .products-table td {
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="header">
            <h5><i class="fas fa-truck"></i> Supplier Details</h5>
            <a href="/supplier/edit/<?= $supplier['supplier_id'] ?>" class="btn btn-edit">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Supplier Name</span>
                <span class="info-value"><?= htmlspecialchars($supplier['supplier_name']) ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Contact Phone</span>
                <span class="info-value"><?= htmlspecialchars($supplier['phone']) ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Email Address</span>
                <span class="info-value"><?= htmlspecialchars($supplier['email']) ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Physical Address</span>
                <span class="info-value"><?= htmlspecialchars($supplier['address']) ?></span>
            </div>
            <div class="info-item">
                <span class="info-label">Relationship Since</span>
                <span class="info-value">
                    <?= isset($supplier['created_at']) 
                        ? htmlspecialchars(date('F j, Y', strtotime($supplier['created_at']))) 
                        : '<span class="text-muted">Not available</span>' ?>
                </span>
            </div>
        </div>

        <div class="products-section">
            <div class="section-header">
                <h6 class="section-title"><i class="fas fa-boxes"></i> Provided Products</h6>
                <span class="product-count"><?= count($supplier['products'] ?? []) ?> items</span>
            </div>

            <div class="table-container">
                <table class="products-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($supplier['products'])): ?>
                            <?php foreach ($supplier['products'] as $index => $product): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($product['product_name']) ?></td>
                                    <td>$<?= number_format($product['price'], 2) ?></td>
                                    <td>
                                        <span class="stock-badge <?= $product['stock'] > 0 ? 'in-stock' : 'out-of-stock' ?>">
                                            <?= htmlspecialchars($product['stock']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <i class="fas fa-box-open"></i>
                                        <h5>No Products Found</h5>
                                        <p>This supplier doesn't have any products listed yet</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="footer">
            <a href="/supplier" class="btn btn-back">Back to Suppliers</a>
        </div>
    </div>
</div>
</body>
</html>