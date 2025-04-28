<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
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
        width: 1000px;
        /* Increased from 800px to 1000px */
        margin: 2rem auto;
        padding: 0 2rem;
    }

    .form-container {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .form-header {
        color: #6c63ff;
        font-weight: 600;
        font-size: 1.75rem;
        margin-bottom: 1.5rem;
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

    .btn-secondary {
        padding: 10px 24px;
        font-size: 16px;
        border-radius: 10px;
    }

    .alert {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 500;
        color: #6c757d;
    }

    .form-control,
    .form-control:focus {
        border-radius: 8px;
        border: 1px solid #ced4da;
    }

    .form-control:focus {
        border-color: #6c63ff;
        box-shadow: 0 0 0 0.2rem rgba(108, 99, 255, 0.25);
    }

    textarea.form-control {
        resize: vertical;
    }

    .products-container {
        max-height: 400px;
        /* Increased height to match wider container */
        overflow-y: auto;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
        margin-top: 10px;
    }

    .form-check {
        padding: 8px 0;
        margin-left: 20px;
        border-bottom: 1px solid #eee;
    }

    .form-check:last-child {
        border-bottom: none;
    }

    .form-check-input {
        margin-top: 0.3em;
    }

    .no-products {
        color: #6c757d;
        font-style: italic;
    }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="form-container">
            <h2 class="form-header">Create New Category</h2>

            <?php if (isset($data['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($data['error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <form action="/category/create" method="POST">
                <div class="mb-3">
                    <label for="category_name" class="form-label">Category Name <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="category_name" name="category_name" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Assign Products</label>
                    <div class="products-container">
                        <?php if (isset($data['products']) && !empty($data['products'])): ?>
                        <?php foreach ($data['products'] as $product): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                id="product_<?= htmlspecialchars($product['product_id']) ?>" name="product_ids[]"
                                value="<?= htmlspecialchars($product['product_id']) ?>">
                            <label class="form-check-label"
                                for="product_<?= htmlspecialchars($product['product_id']) ?>">
                                <?= htmlspecialchars($product['name']) ?>
                                <small class="text-muted">(ID: <?= htmlspecialchars($product['product_id']) ?>)</small>
                            </label>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <div class="no-products">No products available</div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Create Category
                    </button>
                    <a href="/category" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>