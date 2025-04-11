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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Optional Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f8;
        }

        :root {
            --primary: #4361ee;
            --primary-light: #eef2ff;
            --secondary: #3f37c9;
            --success: #4cc9a0;
            --danger: #f72585;
            --warning: #f8961e;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --border-radius: 10px;
            --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        .supplier-detail-container {
            width: 100%;
            max-width: 1200px;
            margin: 1rem 2rem 2rem 1rem; /* Right: 2rem (increased) */
            padding: 1rem;
            height: auto;
        }

        .supplier-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            transition: var(--transition);
        }

        .supplier-card:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .supplier-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .supplier-title {
            margin: 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .supplier-title i {
            font-size: 1.25rem;
        }

        .supplier-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            padding: 2rem;
            margin-left: 0.75rem;
            margin-top: 0.5rem;
            margin-right: 0.75rem; /* Matches margin-left */
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .info-label {
            font-size: 0.85rem;
            color: var(--gray);
            font-weight: 500;
        }

        .info-value {
            font-size: 1rem;
            color: var(--dark);
            font-weight: 500;
        }

        .products-section {
            padding: 0 2rem 2rem;
            margin-left: 0.75rem;
            margin-top: 0.5rem;
            margin-right: 0.75rem; /* Matches margin-left */
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .product-count {
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 500;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
        }

        .products-table-container {
            border-radius: var(--border-radius);
            border: 1px solid var(--light-gray);
            overflow: auto;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        .products-table th {
            background: var(--light);
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--dark);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .products-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--light-gray);
            color: var(--dark);
        }

        .products-table tr:hover {
            background: var(--primary-light);
        }

        .product-name {
            font-weight: 500;
        }

        .stock-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .stock-badge.in-stock {
            background: rgba(76, 201, 160, 0.1);
            color: var(--success);
        }

        .stock-badge.out-of-stock {
            background: rgba(247, 37, 133, 0.1);
            color: var(--danger);
        }

        .empty-state {
            text-align: center;
            padding: 3rem 0;
        }

        .empty-state i {
            font-size: 2.5rem;
            color: var(--light-gray);
            margin-bottom: 1.5rem;
        }

        .empty-state h5 {
            font-size: 1.1rem;
            color: var(--gray);
            font-weight: 500;
        }

        .empty-state p {
            font-size: 0.95rem;
            color: var(--gray);
            opacity: 0.8;
        }

        .supplier-footer {
            padding: 0 2rem 2rem;
            display: flex;
            justify-content: flex-end;
            margin-left: 0.75rem;
            margin-top: 0.5rem;
            margin-right: 0.75rem; /* Matches margin-left */
        }

        .btn-back {
            background: var(--primary-light);
            color: var(--primary);
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
        }

        .btn-edit {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
        }

        .btn-edit:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        @media (max-width: 768px) {
            .supplier-detail-container {
                margin: 0.5rem 1rem 1rem 0.5rem; /* Right: 1rem (increased) */
            }

            .supplier-info-grid {
                grid-template-columns: 1fr;
                margin-left: 0.375rem;
                margin-top: 0.25rem;
                margin-right: 0.375rem; /* Matches margin-left */
            }

            .supplier-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
                padding: 1.25rem;
            }

            .products-section {
                padding: 0 1.25rem 1.25rem;
                margin-left: 0.375rem;
                margin-top: 0.25rem;
                margin-right: 0.375rem; /* Matches margin-left */
            }

            .supplier-footer {
                padding: 0 1.25rem 1.25rem;
                margin-left: 0.375rem;
                margin-top: 0.25rem;
                margin-right: 0.375rem; /* Matches margin-left */
            }

            .products-table {
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
<div class="supplier-detail-container">
    <div class="supplier-card">
        <div class="supplier-header">
            <h5 class="supplier-title">
                <i class="fas fa-truck"></i> Supplier Details
            </h5>
            <div class="supplier-actions">
                <a href="/supplier/edit/<?= $supplier['supplier_id'] ?>" class="btn-edit">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>

        <div class="supplier-body">
            <div class="supplier-info-grid">
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
                    <span class="badge product-count"><?= count($supplier['products'] ?? []) ?> items</span>
                </div>

                <div class="products-table-container">
                    <table class="products-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Last Update</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($supplier['products'])): ?>
                            <?php foreach ($supplier['products'] as $index => $product): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td class="product-name"><?= htmlspecialchars($product['product_name']) ?></td>
                                    <td><?= htmlspecialchars($product['sku'] ?? '—') ?></td>
                                    <td class="text-nowrap">$<?= number_format($product['price'], 2) ?></td>
                                    <td>
                                        <span class="stock-badge <?= $product['stock'] > 0 ? 'in-stock' : 'out-of-stock' ?>">
                                            <?= htmlspecialchars($product['stock']) ?>
                                        </span>
                                    </td>
                                    <td class="text-nowrap">
                                        <?= isset($product['updated_at']) 
                                            ? htmlspecialchars(date('M j, Y', strtotime($product['updated_at']))) 
                                            : '—' ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr class="no-products">
                                <td colspan="6">
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

            <div class="supplier-footer">
                <a href="/supplier" class="btn-back">Back to Suppliers</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>