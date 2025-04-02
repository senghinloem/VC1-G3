<div class="container mt-4 ">
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="fas fa-box me-2"></i>Stock Details
            </h4>
        </div>
        <div class="card-body">
            <?php if (isset($stock)): ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 ms-3">Basic Information</h5>
                            <table class="table table-borderless ms-3">
                                <tr>
                                    <th style="width: 40%">Stock ID</th>
                                    <td><?= htmlspecialchars($stock['stock_id']) ?></td>
                                </tr>
                                <tr>
                                    <th>Stock Name</th>
                                    <td><?= htmlspecialchars($stock['stock_name']) ?></td>
                                </tr>
                                <tr>
                                    <th>Quantity</th>
                                    <td><?= htmlspecialchars($stock['quantity']) ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge <?= $stock['quantity'] > 0 ? 'bg-success' : 'bg-danger' ?>">
                                            <?= $stock['quantity'] > 0 ? 'In Stock' : 'Out of Stock' ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php if (isset($stock['created_at'])): ?>
                                    <tr>
                                        <th>Created At</th>
                                        <td><?= htmlspecialchars($stock['created_at']) ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (isset($stock['updated_at'])): ?>
                                    <tr>
                                        <th>Last Updated</th>
                                        <td><?= htmlspecialchars($stock['updated_at']) ?></td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="/stock" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to Stock
                    </a>
                    <!-- <a href="/stock/edit/<?= $stock['stock_id'] ?>" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a> -->
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash-alt me-1"></i> Delete
                    </button>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">Stock not found.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
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