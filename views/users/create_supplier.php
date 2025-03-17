<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <!-- Card Container -->
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Add New Supplier</h4>
                </div>
                <div class="card-body">
                    <!-- Form Start -->
                    <form id="supplierForm" action="/supplier/store" method="POST">
                        <!-- Supplier Name -->
                        <div class="mb-3">
                            <label for="supplier_name" class="form-label">Supplier Name</label>
                            <input type="text" id="supplier_name" name="supplier_name" class="form-control" placeholder="Enter supplier name" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Enter supplier email" required>
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter supplier phone" required>
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" id="address" name="address" class="form-control" placeholder="Enter supplier address" required>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-success w-100 shadow-sm">
                            <i class="bi bi-check-circle"></i> Add Supplier
                        </button>
                    </form>
                    <!-- Form End -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Bootstrap and Iconic Font links -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">

<!-- Optional: Add Bootstrap JS link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom CSS for Light Placeholder Color -->
<style>
    ::placeholder {
        color: #B0B0B0 !important; /* Lighter gray placeholder color */
        opacity: 1; /* Ensure the opacity is fully visible */
    }
</style>