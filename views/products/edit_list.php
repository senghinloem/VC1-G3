<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            margin: 0;
        }
        .container {
            margin-top: 30px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 15px 25px;
        }
        .card-body {
            padding: 25px;
        }
        .form-label {
            font-weight: 600;
            color: #343a40;
        }
        .form-control {
            border-radius: 8px;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #ccc;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        .btn {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 25px;
            transition: background-color 0.3s ease;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Edit Product</h4>
                <p class="mb-0">Update your product details below</p>
            </div>
            <div class="card-body">
                <?php if (isset($product) && is_array($product)): ?>
                    <form action="/product_list/update" method="POST">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']) ?>">
                        <div class="row g-3">
                            <!-- Product Name -->
                            <div class="col-md-3">
                                <label class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
                            </div>
                            <!-- Description -->
                            <div class="col-md-3">
                                <label class="form-label">Description</label>
                                <input type="text" class="form-control" id="description" name="description" value="<?= htmlspecialchars($product['description'] ?? '') ?>">
                            </div>
                            <!-- Product Price -->
                            <div class="col-md-3">
                                <label class="form-label">Product Price ($)</label>
                                <input type="number" class="form-control" id="price" name="price" value="<?= htmlspecialchars($product['price']) ?>" step="0.01" required>
                            </div>
                            <!-- Unit -->
                            <div class="col-md-3">
                                <label class="form-label">Unit</label>
                                <input type="text" class="form-control" id="unit" name="unit" value="<?= htmlspecialchars($product['unit']) ?>" required>
                            </div>
                            <!-- Submit and Cancel buttons -->
                            <div class="col-md-12 d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">Update Product</button>
                                <a href="/product_list" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                <?php else: ?>
                    <p>Product details not available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>