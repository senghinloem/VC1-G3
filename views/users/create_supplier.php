<div class="container">

            <div class="modal-header">
                <h5 class="modal-title" id="supplierModalLabel">Add New Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="supplierForm" action="/supplier/store" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Supplier Name</label>
                        <input type="text" id="supplier_name" name="supplier_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" id="phone" name="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" id="address" name="address" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success">Add Supplier</button>
                </form>
            </div>
      
</div>