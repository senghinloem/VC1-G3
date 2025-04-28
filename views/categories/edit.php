<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
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
    </style>
</head>

<body>
    <div class="main-container">
        <div class="form-container">
            <h2 class="form-header">Edit Category</h2>

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
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-pencil-fill me-2"></i>Update Category
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