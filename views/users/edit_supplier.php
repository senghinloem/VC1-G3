<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-11">
            <!-- Card Container -->
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Edit Supplier</h4>
                </div>
                <div class="card-body">
                    <!-- Form Start -->
                    <form id="supplierForm" action="/supplier/update/<?= $supplier['supplier_id']; ?>" method="POST">
                        <!-- Hidden method field to simulate PUT request -->
                        <input type="hidden" name="_method" value="PUT">

                        <!-- Supplier Name -->
                        <div class="mb-3">
                            <label for="supplier_name" class="form-label">Supplier Name</label>
                            <input type="text" id="supplier_name" name="supplier_name" value="<?= htmlspecialchars($supplier['supplier_name']); ?>" class="form-control" placeholder="Enter supplier name" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" value="<?= htmlspecialchars($supplier['email']); ?>" class="form-control" placeholder="Enter supplier email" required>
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($supplier['phone']); ?>" class="form-control" placeholder="" required>
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" id="address" name="address" value="<?= htmlspecialchars($supplier['address']); ?>" class="form-control" placeholder="" required>
                        </div>

                        <!-- Button Group -->
                        <div class="d-flex justify-content-end gap-2">
                            <!-- Cancel Button -->
                            <a href="/supplier" class="btn btn-secondary">Cancel</a>
                        
                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary" id="submitButton">
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="loadingSpinner"></span>
                                Save
                            </button>
                        </div>

                    </form>
                    <!-- Form End -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap and Iconic Font links -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">

<!-- Optional: Add Bootstrap JS link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
