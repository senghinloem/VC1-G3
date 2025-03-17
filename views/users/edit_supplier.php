<div class="container">
    <div class="modal-header">
        <h5 class="modal-title" id="supplierModalLabel">Edit Supplier</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form id="supplierForm" action="/supplier/update/<?= $supplier['supplier_id']; ?>" method="POST">
            <!-- Hidden method field to simulate PUT request -->
            <input type="hidden" name="_method" value="PUT">
            
            <div class="mb-3">
                <label class="form-label">Supplier Name</label>
                <input type="text" id="supplier_name" name="supplier_name" value="<?= htmlspecialchars($supplier['supplier_name']); ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($supplier['email']); ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($supplier['phone']); ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" id="address" name="address" value="<?= htmlspecialchars($supplier['address']); ?>" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Update Supplier</button>
        </form>
    </div>
</div>
