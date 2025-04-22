<?php
// Ensure $stock_management is initialized as an empty array if not set
if (!isset($stock_management)) {
    $stock_management = [];
}
?>

<div class="container mt-4 px-4">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header bg-white p-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <h4 class="mb-0 d-flex align-items-center">
                        <i class="fas fa-boxes me-2 text-primary"></i> Stock Management
                    </h4>
                    <div class="d-flex flex-wrap gap-3">
                    <div class="search-container">
                                    <form action="/suppliers/search" method="GET" class="d-flex align-items-center" id="searchForm">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control" 
                                                   placeholder="Search for supplier..." 
                                                   id="searchInput">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                        <a href="/stock/create" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Create Stock
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Out of Product (Quantity = 0) -->
    <h4 class="text-danger mt-5" style="margin-left: 2cm;">Out of Stock</h4>
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-container">
                    <table class="table table-borderless">
                        <thead style="background-color: #f8f9fa; position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;">ID</th>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;">Stock Name</th>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;">Product</th>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;">Quantity Product</th>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;">Status</th>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($stock_management)): ?>
                                <?php $displayIndex = 0; ?>
                                <?php foreach ($stock_management as $index => $item): ?>
                                    <?php if ((int)($item['quantity'] ?? 0) === 0): ?>
                                        <tr style="background-color: <?= $displayIndex % 2 === 0 ? '#f5f6f5' : '#ffffff'; ?>;">
                                            <td style="color: #6c757d;"><?= $displayIndex + 1 ?></td>
                                            <td style="color: #6c757d;"><?= htmlspecialchars($item['stock_name'] ?? '') ?></td>
                                            <td style="color: #6c757d;"><?= htmlspecialchars($item['product_name'] ?? $item['product'] ?? 'N/A') ?></td>
                                            <td style="color: #6c757d;"><?= htmlspecialchars($item['quantity'] ?? 0) ?></td>
                                            <td>
                                                <span class="badge" style="background-color: #dc3545; color: white; padding: 5px 10px; border-radius: 12px;">
                                                    Out of Stock
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <button class="action-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Actions" style="border: none; outline: none; background: none;">
                                                    <i class="fa-solid fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" style="border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                                    <li><a class="dropdown-item" href="/stock/view/<?= htmlspecialchars($item['stock_id']) ?>"><i class="fas fa-eye text-primary me-2"></i> View</a></li>
                                                    <li><a class="dropdown-item" href="/stock/edit/<?= htmlspecialchars($item['stock_id']) ?>"><i class="fas fa-edit text-success me-2"></i> Edit</a></li>
                                                    <li>
                                                        <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-stockid="<?= htmlspecialchars($item['stock_id']) ?>" data-stockname="<?= htmlspecialchars($item['stock_name'] ?? '') ?>">
                                                            <i class="fas fa-trash-alt me-2"></i> Delete
                                                        </button>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <?php $displayIndex++; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center" style="color: #6c757d;">No stock data available.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Low Product (Quantity 1-499) -->
    <h4 class="text-warning mt-5" style="margin-left: 2cm;">Low Stock</h4>
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-container">
                    <table class="table table-borderless">
                        <thead style="background-color: #f8f9fa; position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;">ID</th>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;">Stock Name</th>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;">Product</th>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;">Quantity Product</th>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;">Status</th>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($stock_management)): ?>
                                <?php $displayIndex = 0; ?>
                                <?php foreach ($stock_management as $index => $item): ?>
                                    <?php if ((int)($item['quantity'] ?? 0) > 0 && (int)($item['quantity'] ?? 0) <=  50): ?>
                                        <tr style="background-color: <?= $displayIndex % 2 === 0 ? '#f5f6f5' : '#ffffff'; ?>;">
                                            <td style="color: #6c757d;"><?= $displayIndex + 1 ?></td>
                                            <td style="color: #6c757d;"><?= htmlspecialchars($item['stock_name'] ?? '') ?></td>
                                            <td style="color: #6c757d;"><?= htmlspecialchars($item['product_name'] ?? $item['product'] ?? 'N/A') ?></td>
                                            <td style="color: #6c757d;"><?= htmlspecialchars($item['quantity'] ?? 0) ?></td>
                                            <td>
                                                <span class="badge" style="background-color: #ffc107; color: white; padding: 5px 10px; border-radius: 12px;">
                                                    Low Stock
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <button class="action-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Actions" style="border: none; outline: none; background: none;">
                                                    <i class="fa-solid fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" style="border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                                    <li><a class="dropdown-item" href="/stock/view/<?= htmlspecialchars($item['stock_id']) ?>"><i class="fas fa-eye text-primary me-2"></i> View</a></li>
                                                    <li><a class="dropdown-item" href="/stock/edit/<?= htmlspecialchars($item['stock_id']) ?>"><i class="fas fa-edit text-success me-2"></i> Edit</a></li>
                                                    <li>
                                                        <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-stockid="<?= htmlspecialchars($item['stock_id']) ?>" data-stockname="<?= htmlspecialchars($item['stock_name'] ?? '') ?>">
                                                            <i class="fas fa-trash-alt me-2"></i> Delete
                                                        </button>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <?php $displayIndex++; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center" style="color: #6c757d;">No stock data available.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Has Product (Quantity >= 500) -->
    <h4 class="text-primary mt-5" style="margin-left: 2cm;">In Stock</h4>
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-container">
                    <table class="table table-borderless">
                        <thead style="background-color: #f8f9fa; position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;">ID</th>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;">Stock Name</th>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;">Product</th>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;">Quantity Product</th>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;">Status</th>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($stock_management)): ?>
                                <?php $displayIndex = 0; ?>
                                <?php foreach ($stock_management as $index => $item): ?>
                                    <?php if ((int)($item['quantity'] ?? 0) >= 60): ?>
                                        <tr style="background-color: <?= $displayIndex % 2 === 0 ? '#f5f6f5' : '#ffffff'; ?>;">
                                            <td style="color: #6c757d;"><?= $displayIndex + 1 ?></td>
                                            <td style="color: #6c757d;"><?= htmlspecialchars($item['stock_name'] ?? '') ?></td>
                                            <td style="color: #6c757d;"><?= htmlspecialchars($item['product_name'] ?? $item['product'] ?? 'N/A') ?></td>
                                            <td style="color: #6c757d;"><?= htmlspecialchars($item['quantity'] ?? 0) ?></td>
                                            <td>
                                                <span class="badge" style="background-color: #28a745; color: white; padding: 5px 10px; border-radius: 12px;">
                                                    In Stock
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <button class="action-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Actions" style="border: none; outline: none; background: none;">
                                                    <i class="fa-solid fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" style="border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                                    <li><a class="dropdown-item" href="/stock/view/<?= htmlspecialchars($item['stock_id']) ?>"><i class="fas fa-eye text-primary me-2"></i> View</a></li>
                                                    <li><a class="dropdown-item" href="/stock/edit/<?= htmlspecialchars($item['stock_id']) ?>"><i class="fas fa-edit text-success me-2"></i> Edit</a></li>
                                                    <li>
                                                        <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-stockid="<?= htmlspecialchars($item['stock_id']) ?>" data-stockname="<?= htmlspecialchars($item['stock_name'] ?? '') ?>">
                                                            <i class="fas fa-trash-alt me-2"></i> Delete
                                                        </button>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <?php $displayIndex++; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center" style="color: #6c757d;">No stock data available.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-3">
                    <i class="fas fa-exclamation-triangle text-warning fa-3x"></i>
                </div>
                <h5 class="mb-2">Are you sure?</h5>
                <p class="text-muted mb-0">You are about to delete stock <strong id="deleteStockName"></strong>. This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" action="">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-2"></i>Delete Stock
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteModal = document.getElementById('confirmDeleteModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const stockId = button.getAttribute('data-stockid');
                const stockName = button.getAttribute('data-stockname');
                document.getElementById('deleteStockName').textContent = stockName;
                document.getElementById('deleteForm').action = `/stock/delete/${stockId}`;
            });
        }

        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        if (searchInput && searchForm) {
            searchInput.addEventListener('keyup', function(event) {
                if (event.key === 'Enter') {
                    searchForm.submit();
                }
            });
        }
    });
</script>