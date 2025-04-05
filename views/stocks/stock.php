
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
                            <form action="/stock/search" method="GET" class="d-flex align-items-center" id="searchForm">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search stock..." value="" id="searchInput">
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

    <!-- Feedback Messages -->
    <?php
    if (isset($_GET['success']) && $_GET['success'] === 'stock_deleted') {
        echo '<div class="alert alert-success">Stock deleted successfully!</div>';
    } elseif (isset($_GET['error'])) {
        echo '<div class="alert alert-danger">Error: ' . htmlspecialchars($_GET['error']) . '</div>';
    }
    ?>

    <!-- Stock Has No Product -->
    <h4 class="text-danger mt-5" style="margin-left: 2cm;">Stock has no product</h4>
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-container">
                    <table class="table table-borderless">
                        <thead style="background-color: #f8f9fa; position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;">ID</th>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;">Stock Name</th>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;">Quantity</th>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;">Status</th>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($stock_management)): ?>
                                <?php foreach ($stock_management as $index => $item): ?>
                                    <?php if ((int)$item['quantity'] <= 0): ?>
                                        <tr style="background-color: <?= $index % 2 === 0 ? '#f5f6f5' : '#ffffff'; ?>;">
                                            <td style="color: #6c757d;"><?= htmlspecialchars($item['stock_id']) ?></td>
                                            <td style="color: #6c757d;"><?= htmlspecialchars($item['stock_name']) ?></td>
                                            <td style="color: #6c757d;"><?= htmlspecialchars($item['quantity']) ?></td>
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
                                                        <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-stockid="<?= htmlspecialchars($item['stock_id']) ?>" data-stockname="<?= htmlspecialchars($item['stock_name']) ?>">
                                                            <i class="fas fa-trash-alt me-2"></i> Delete
                                                        </button>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center" style="color: #6c757d;">No stock data available.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Has Product -->
    <h4 class="text-primary mt-5" style="margin-left: 2cm;">Stock has product</h4>
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-container">
                    <table class="table table-borderless">
                        <thead style="background-color: #f8f9fa; position: sticky; top: 0; z-index: 10;">
                            <tr>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;">ID</th>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;">Stock Name</th>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;">Quantity</th>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;">Status</th>
                                <th style="font-weight: bold; text-transform: uppercase; color: #6c757d;" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($stock_management)): ?>
                                <?php foreach ($stock_management as $index => $item): ?>
                                    <?php if ((int)$item['quantity'] > 0): ?>
                                        <tr style="background-color: <?= $index % 2 === 0 ? '#f5f6f5' : '#ffffff'; ?>;">
                                            <td style="color: #6c757d;"><?= htmlspecialchars($item['stock_id']) ?></td>
                                            <td style="color: #6c757d;"><?= htmlspecialchars($item['stock_name']) ?></td>
                                            <td style="color: #6c757d;"><?= htmlspecialchars($item['quantity']) ?></td>
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
                                                        <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-stockid="<?= htmlspecialchars($item['stock_id']) ?>" data-stockname="<?= htmlspecialchars($item['stock_name']) ?>">
                                                            <i class="fas fa-trash-alt me-2"></i> Delete
                                                        </button>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center" style="color: #6c757d;">No stock data available.</td></tr>
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

<!-- Add this JavaScript at the bottom of your existing stock.php file -->
<script>
// Initialize the delete modal with the correct stock data
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
    
    // Search functionality
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

// Go to specific page
function goToPage(page) {
    if (page < 1 || page > totalPages) return;
    
    currentPage = page;
    const rows = document.querySelectorAll('#productTableBody tr');
    
    // Hide all rows
    rows.forEach(row => row.style.display = 'none');
    
    // Show rows for current page
    const startIndex = (page - 1) * itemsPerPage;
    const endIndex = Math.min(startIndex + itemsPerPage, totalItems);
    
    for (let i = startIndex; i < endIndex; i++) {
        if (rows[i]) {
            rows[i].style.display = '';
        }
    }
    
    // Update pagination controls
    document.querySelectorAll('.page-item').forEach(item => {
        item.classList.remove('active');
        if (item.textContent === page.toString()) {
            item.classList.add('active');
        }
    });
    
    document.getElementById('prevPage').classList.toggle('disabled', page === 1);
    document.getElementById('nextPage').classList.toggle('disabled', page === totalPages);
    
    // Update showing text
    document.getElementById('showingFrom').textContent = startIndex + 1;
    document.getElementById('showingTo').textContent = endIndex;
}

// Initialize on page load
function goToPage(page) {
    if (page < 1 || page > totalPages) return;
    
    currentPage = page;
    const rows = document.querySelectorAll('#productTableBody tr');
    
    // Hide all rows
    rows.forEach(row => row.style.display = 'none');
    
    // Show rows for current page
    const startIndex = (page - 1) * itemsPerPage;
    const endIndex = Math.min(startIndex + itemsPerPage, totalItems);
    
    for (let i = startIndex; i < endIndex; i++) {
        if (rows[i]) {
            rows[i].style.display = '';
        }
    }
    
    // Update pagination controls
    document.querySelectorAll('.page-item').forEach(item => {
        item.classList.remove('active');
        if (item.textContent === page.toString()) {
            item.classList.add('active');
        }
    });
    
    document.getElementById('prevPage').classList.toggle('disabled', page === 1);
    document.getElementById('nextPage').classList.toggle('disabled', page === totalPages);
    
    // Update showing text
    document.getElementById('showingFrom').textContent = startIndex + 1;
    document.getElementById('showingTo').textContent = endIndex;
}

// Initialize on page load
// document.addEventListener('DOMContentLoaded', function() {
//     initPagination();
//     goToPage(1);
    
//     // Existing search functionality
//     document.getElementById('searchInput').addEventListener('input', function() {
//         const searchValue = this.value.toLowerCase();
//         const rows = document.querySelectorAll('#productTableBody tr');

//         rows.forEach(row => {
//             const name = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
//             const description = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
//             const price = row.querySelector('td:nth-child(6)').textContent; 
//             const unit = row.querySelector('td:nth-child(7)').textContent; 
//             const quantity = row.querySelector('td:nth-child(8)').textContent; 
//             const stock = row.querySelector('td:nth-child(9)').textContent; 

//             if (
//                 name.includes(searchValue) || 
//                 description.includes(searchValue) ||
//                 price.includes(this.value) || 
//                 unit.includes(this.value) || 
//                 quantity.includes(this.value) ||
//                 stock.includes(searchValue)
//             ) {
//                 row.style.display = '';
//             } else {
//                 row.style.display = 'none';
//             }
//         });
//     });

</script>

