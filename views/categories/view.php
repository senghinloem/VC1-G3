<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
    body {
        background-color: #f9fafb;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .main-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 0 2rem;
    }

    .detail-container {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .detail-header {
        color: #6c63ff;
        font-weight: 600;
        font-size: 1.75rem;
        margin-bottom: 1.5rem;
    }

    .detail-label {
        font-weight: 500;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .detail-value {
        margin-bottom: 1.5rem;
        color: #343a40;
    }

    .btn-primary {
        background-color: #6c63ff;
        border-color: #6c63ff;
        padding: 10px 24px;
        font-size: 16px;
        border-radius: 10px;
    }

    .btn-primary:hover {
        background-color: #5a51e6;
        border-color: #5a51e6;
    }

    .table {
        border-radius: 8px;
        overflow: hidden;
    }

    .table th {
        background-color: #f1f3f5;
        color: #6c757d;
        font-weight: 500;
    }

    .table td {
        vertical-align: middle;
    }

    .alert {
        margin-bottom: 1.5rem;
    }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="detail-container">
            <h2 class="detail-header">Category Details</h2>

            <?php if (isset($data['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($data['error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <div class="detail-label">Category Name</div>
            <div class="detail-value"><?= htmlspecialchars($data['category']['category_name']) ?></div>

            <div class="detail-label">Description</div>
            <div class="detail-value">
                <?= htmlspecialchars($data['category']['description'] ?? 'No description provided') ?>
            </div>

            <div class="detail-label">Created At</div>
            <div class="detail-value">
                <?= htmlspecialchars(date('F j, Y, g:i a', strtotime($data['category']['created_at']))) ?></div>

            <div class="detail-label">Assigned Products</div>
            <?php if (!empty($data['products'])): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['products'] as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= htmlspecialchars($product['description'] ?? 'N/A') ?></td>
                        <td>$<?= number_format($product['price'], 2) ?></td>
                        <td><?= htmlspecialchars($product['unit'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($product['quantity']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="detail-value text-muted">No products assigned to this category.</div>
            <?php endif; ?>

            <a href="/category" class="btn btn-primary mt-3">
                <i class="bi bi-arrow-left me-2"></i>Back to Categories
            </a>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>