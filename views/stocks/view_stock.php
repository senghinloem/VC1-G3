<form id="adjustStockForm" method="POST" action="/stock/adjust/<?= $stock['stock_id'] ?>">
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
                                                <th>Quantity</th>
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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#saveModal">
                    <i class="fas fa-save me-1"></i> Save
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-exclamation-triangle text-danger fa-3x"></i>
                    </div>
                    <p class="text-center">Are you sure you want to delete this stock item?</p>
                    <p class="text-center fw-bold"><?= isset($stock) ? htmlspecialchars($stock['stock_name']) : '' ?></p>
                    <p class="text-center text-muted">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="/stock/delete/<?= isset($stock) ? $stock['stock_id'] : '' ?>" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Confirmation Modal -->
    <div class="modal fade" id="saveModal" tabindex="-1" aria-labelledby="saveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="saveModalLabel">Confirm Save</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-exclamation-triangle text-warning fa-3x"></i>
                    </div>
                    <p class="text-center">Are you sure?</p>
                    <p class="text-center">You are about to save stock <strong><?= isset($stock) ? htmlspecialchars($stock['stock_name']) : '' ?></strong>.</p>
                    <p class="text-center text-muted">Please confirm to proceed.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmSaveButton">
                        <i class="fas fa-save me-1"></i> Save Stock
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to Handle Save Confirmation -->
    <script>
    document.getElementById('confirmSaveButton').addEventListener('click', function() {
        // Submit the form when the "Save Stock" button in the modal is clicked
        document.getElementById('adjustStockForm').submit();
    });
    </script>
</form>