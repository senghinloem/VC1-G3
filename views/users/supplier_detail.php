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