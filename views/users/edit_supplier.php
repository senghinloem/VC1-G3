<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
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
                            <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($supplier['phone']); ?>" class="form-control" placeholder="Enter supplier phone" required>
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" id="address" name="address" value="<?= htmlspecialchars($supplier['address']); ?>" class="form-control" placeholder="Enter supplier address" required>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check-circle"></i> Update Supplier
                        </button>
                    </form>
                    <!-- Form End -->
                </div>
            </div>
        </div>
    </div>
</div>
