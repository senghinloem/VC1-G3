
<form method="POST" action="/stock/adjust/<?= $stock['stock_id'] ?>">
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-box me-2"></i>Stock Details
                </h4>
            </div>
            <div class="card-body">
                <?php if (isset($stock)): ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-4">
                                <h5 class="border-bottom pb-2 ms-3">Basic Information</h5>
                                <div class="d-flex justify-content-between gap-3">
                                    <!-- Stock Details on the Left -->
                                    <div class="flex-grow-1 mt-3">
                                        <table class="table table-borderless ms-3">
                                            <tr>
                                                <th style="width: 40%">Stock ID</th>
                                                <td style="width: 60%"><?= htmlspecialchars($stock['stock_id']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Stock Name</th>
                                                <td><?= htmlspecialchars($stock['stock_name']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Product</th>
                                                <td><?= htmlspecialchars($stock['product'] ?? 'No product associated') ?></td>
                                            </tr>
                                            <tr>
                                                <th>Current Quantity</th>
                                                <td><?= htmlspecialchars($stock['stock_quantity']) ?></td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    <span class="badge <?= $stock['stock_quantity'] > 0 ? 'bg-success' : 'bg-danger' ?>">
                                                        <?= $stock['stock_quantity'] > 0 ? 'Available' : 'Unavailable' ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Last Updated</th>
                                                <td><?= htmlspecialchars($stock['last_updated']) ?></td>
                                            </tr>
                                        </table>
                                    </div>

                                    <!-- Add Item/Subtract Form on the Right -->
                                    <div class="me-5 mb-5" style="width: 300px;">
                                        <div class="form-group mb-3">
                                            <label for="add_quantity" style="font-size: 18px;" class="mt-4">Add Item</label>
                                            <input type="number"
                                                id="add_quantity"
                                                name="add_quantity"
                                                class="form-control"
                                                placeholder="Enter Quantity"
                                                min="0"
                                                value="0"
                                                style="width: 100%; padding: 12px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc;">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="subtract_quantity" style="font-size: 18px;" class="mt-4">Subtract</label>
                                            <input type="number"
                                                id="subtract_quantity"
                                                name="subtract_quantity"
                                                class="form-control"
                                                placeholder="Enter Quantity"
                                                min="0"
                                                value="0"
                                                style="width: 100%; padding: 12px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger">Stock not found.</div>
                <?php endif; ?>
            </div>

            <div class="d-flex justify-content-end gap-2 mb-5 me-5 mt-4">
                <a href="/stock" class="btn btn-primary btn-sm me-2">
                    <i class="fas fa-arrow-left me-1"></i> Back to Stock
                </a>
                <button type="button" class="btn btn-primary" id="adjustStockButton">
                    <i class="fas fa-save me-1"></i> Adjust Stock
                </button>
            </div>
        </div>
    </div>

    <!-- Adjustment Confirmation Modal -->
    <div class="modal fade" id="adjustmentModal" tabindex="-1" aria-labelledby="adjustmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="adjustmentModalLabel">Confirm Stock Adjustment</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-exclamation-triangle text-warning fa-3x"></i>
                    </div>
                    <p class="text-center">Please confirm your stock adjustment:</p>
                    
                    <div class="adjustment-details">
                        <p><strong>Stock Name:</strong> <span id="modalStockName"><?= htmlspecialchars($stock['stock_name'] ?? '') ?></span></p>
                        <p><strong>Current Quantity:</strong> <span id="modalCurrentQty"><?= htmlspecialchars($stock['stock_quantity'] ?? 0) ?></span></p>
                        <p><strong>Quantity to Add:</strong> <span id="modalAddQty">0</span></p>
                        <p><strong>Quantity to Subtract:</strong> <span id="modalSubtractQty">0</span></p>
                        <p><strong>New Quantity:</strong> <span id="modalNewQty"><?= htmlspecialchars($stock['stock_quantity'] ?? 0) ?></span></p>
                    </div>
                    
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        This action cannot be undone. Please verify the quantities before proceeding.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="confirmAdjustment">
                        <i class="fas fa-check-circle me-1"></i> Confirm Adjustment
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const adjustBtn = document.getElementById('adjustStockButton');
    const addQtyInput = document.getElementById('add_quantity');
    const subtractQtyInput = document.getElementById('subtract_quantity');
    const modal = new bootstrap.Modal(document.getElementById('adjustmentModal'));
    
    adjustBtn.addEventListener('click', function() {
        const addQty = parseInt(addQtyInput.value) || 0;
        const subtractQty = parseInt(subtractQtyInput.value) || 0;
        const currentQty = parseInt(document.getElementById('modalCurrentQty').textContent);
        
        // Update modal with the values
        document.getElementById('modalAddQty').textContent = addQty;
        document.getElementById('modalSubtractQty').textContent = subtractQty;
        document.getElementById('modalNewQty').textContent = currentQty + addQty - subtractQty;
        
        // Validate that at least one field has a value
        if (addQty === 0 && subtractQty === 0) {
            alert('Please enter a quantity to add or subtract');
            return;
        }
        
        // Validate that subtract quantity doesn't exceed current + added quantity
        if (subtractQty > (currentQty + addQty)) {
            alert('Subtract quantity cannot exceed current quantity plus added quantity');
            return;
        }
        
        // Show the modal
        modal.show();
    });
    
    // Prevent form submission when pressing enter in input fields
    [addQtyInput, subtractQtyInput].forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                adjustBtn.click();
            }
        });
    });
});
</script>