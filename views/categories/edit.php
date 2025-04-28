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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #f9fafb;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .main-container {
        width: 1000px;
        /* Match Create Category */
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
        color: #0d6efd;
        /* Match Category Management */
        font-weight: 600;
        font-size: 1.75rem;
        margin-bottom: 1.5rem;
    }

    .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
        padding: 10px 24px;
        font-size: 16px;
        border-radius: 10px;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        border-color: #0b5ed7;
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
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    textarea.form-control {
        resize: vertical;
    }

    .products-container {
        max-height: 400px;
        /* Match Create Category */
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
            <h2 class="form-header"><i class="fas fa-folder me-2"></i>Edit Category</h2>

            <?php if (isset($data['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($data['error']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <form action="/category/edit/<?= htmlspecialchars($data['category']['category_id']) ?>" method="POST">
                <div class="mb-3">
                    <label for="category_name" class="form-label">Category Name <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="category_name" name="category_name"
                        value="<?= htmlspecialchars($data['category']['category_name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description"
                        rows="4"><?= htmlspecialchars($data['category']['description'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Assign Products</label>
                    <div class="products-container">
                        <?php if (isset($data['products']) && !empty($data['products'])): ?>
                        <?php foreach ($data['products'] as $product): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                id="product_<?= htmlspecialchars($product['product_id']) ?>" name="product_ids[]"
                                value="<?= htmlspecialchars($product['product_id']) ?>"
                                <?= in_array($product['product_id'], $data['assigned_product_ids']) ? 'checked' : '' ?>>
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
                        <i class="fas fa-save me-2"></i>Update Category
                    </button>
                    <a href="/category" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>