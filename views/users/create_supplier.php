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
</head>

<body>

    <!-- Main Container -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-11">

                <!-- Success Alert -->
                <!-- This will be shown when a new supplier is successfully added -->
                <div id="successMessage" class="alert alert-success d-none" role="alert">
                    Supplier Created successfully!
                </div>

                <!-- Card for Add Supplier -->
                <div class="card border-0 rounded-lg">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Create New Supplier</h4>
                    </div>
                    <div class="card-body">

                        <!-- Supplier Form -->
                        <form id="supplierForm" action="/supplier/store" method="POST" onsubmit="showSuccessMessage(event)">

                            <!-- Supplier Name -->
                            <div class="mb-3">
                                <label for="supplier_name" class="form-label">Supplier Name</label>
                                <input type="text" id="supplier_name" name="supplier_name" class="form-control"
                                    placeholder="" required>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="" required>
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                    placeholder="" required>
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" id="address" name="address" class="form-control"
                                    placeholder="" required>
                            </div>

                            <!-- Button Group (close together) -->
                            <div class="d-flex gap-2 mt-4 justify-content-end">
                                <!-- Cancel Button -->
                                <a href="/suppliers" class="btn btn-secondary w-40">Cancel</a>
                            
                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary w-40">Create Supplier</button>
                            </div>


                        </form>
                    </div>
                </div>
                <!-- End Card -->

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
