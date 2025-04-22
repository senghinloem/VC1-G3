<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Supplier</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
</head>

<body>
    <!-- Main Container -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-11">
                <!-- Success Alert -->
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?>
                    </div>
                <?php endif; ?>

                <!-- Error Message -->
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?>
                    </div>
                <?php endif; ?>

                <!-- Card for Add Supplier -->
                <div class="card border-0 rounded-lg">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Create New Supplier</h4>
                    </div>
                    <div class="card-body">
                        <!-- Supplier Form -->
                        <form id="supplierForm" action="/supplier/store" method="POST">
                            <!-- Supplier Name -->
                            <div class="mb-3">
                                <label for="supplier_name" class="form-label">Supplier Name <span class="text-danger">*</span></label>
                                <input type="text" id="supplier_name" name="supplier_name" class="form-control" required>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" id="phone" name="phone" class="form-control">
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" id="address" name="address" class="form-control">
                            </div>

                            <!-- Products -->
                            <div class="mb-3">
                                <label for="products" class="form-label">Select Products Provided</label>
                                <select id="products" name="products[]" class="form-select" multiple>
                                    <?php foreach ($products as $product): ?>
                                        <option value="<?= $product['product_id'] ?>"><?= htmlspecialchars($product['name']) ?></option>
                                    <?php endforeach; ?>
                                    </select>
                            </div>

                            <!-- Button Group -->
                            <div class="d-flex gap-2 mt-4 justify-content-end">
                                <a href="/supplier" class="btn btn-secondary w-40">Cancel</a>
                                <button type="submit" class="btn btn-primary w-40">Create Supplier</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Select2
        $(document).ready(function() {
            $('#products').select2({
                placeholder: "Select products",
                allowClear: true
            });
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>