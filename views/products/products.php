<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory System Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    
<div class="container mt-4">
    <!-- Header Section -->
    <div class="header-section" style="margin-top: 1px;">
    
        <h4>
            <i class="fas fa-box me-2 text-primary"></i> Products
        </h4>
        <div class="search-container">
            <div class="input-group">
                <input type="text" class="form-control border-start-0" id="searchInput" placeholder="Search for product...">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="button-group">
            <a href="/create" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Product
            </a>
            <input type="file" id="excelFileInput" accept=".xlsx, .xls" style="display: none;">
            <button class="btn btn-dark" id="importProductsButton">
                <i class="fas fa-file-import me-2"></i>Import Products
            </button>
        </div>
    </div> 


    <div class="col-12 mb-4">
        <div class="row">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stat-card total-users">
                    <h3><?= number_format($totalUsers ?? 0) ?></h3>
                    <p>Total Products</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stat-card online-users">
                    <h3><?= number_format($activeUsers ?? 0) ?></h3>
                    <p>Online Users</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stat-card offline-users">
                    <h3><?= number_format($inactiveUsers ?? 0) ?></h3>
                    <p>Offline Users</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="stat-card online-rate">
                    <h3></h3>
                    <p>Online Rate</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="action-buttons mb-4">
        <button class="btn btn-danger" id="deleteSelected" type="button" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">Delete</button>
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="stockDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Select Stock
            </button>
            <ul class="dropdown-menu" aria-labelledby="stockDropdown">
                <?php if (!empty($stocks)): ?>
                    <?php foreach ($stocks as $stock): ?>
                        <li><a class="dropdown-item" href="#" data-stock-id="<?= htmlspecialchars($stock['stock_id']) ?>" data-stock-name="<?= htmlspecialchars($stock['stock_name']) ?>">
                            <?= htmlspecialchars($stock['stock_name']) ?>
                        </a></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li><span class="dropdown-item text-muted">No stocks available</span></li>
                <?php endif; ?>
            </ul>
        </div>
        <button class="btn btn-success" id="applyStock" disabled>Apply to Selected</button>
        <button class="btn btn-outline-secondary" id="clearStockSelection">Clear</button>
    </div>
    
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Barcode</th>
                    <th scope="col">Price</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Quantity</th>
                </tr>
            </thead>
            <tbody id="productTableBody">
                <?php if (!empty($products) && is_array($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><input type="checkbox" class="productCheckbox" value="<?= $product['product_id'] ?>"></td>
                            <td>
                                <img class="default-product-image" src="<?= htmlspecialchars($product['image']) ?>" alt="no image<?= htmlspecialchars($product['name']) ?>" style="width: 80px; height: 80px;">
                            </td>
                            <td>
                                <span class="product-name-box"><?= htmlspecialchars($product['name']) ?></span>
                            </td>
                            <td><?= htmlspecialchars($product['description']) ?></td>
                            <td>
                                <div class="barcode-search">
                                    <i class="bi bi-upc barcode-icon"></i>
                                    <span class="barcode-text">Find product by barcode</span>
                                    <i class="bi bi-search search-icon"></i>
                                </div>
                            </td>
                            <td>$<?= htmlspecialchars($product['price']) ?></td>
                            <td><?= htmlspecialchars($product['unit']) ?></td>
                            <td><?= htmlspecialchars($product['quantity']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr class="empty-state">
                        <td colspan="7" class="text-center">
                            <i class="bi bi-box-seam" style="font-size: 3rem; color: #adb5bd;"></i>
                            <p class="mt-2 mb-0">No products found</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Controls -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="text-muted">
            Showing <span id="showingFrom">1</span> to <span id="showingTo"><?= min(8, count($products)) ?></span> of <span id="totalItems"><?= count($products) ?></span> entries
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item disabled" id="prevPage">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <!-- Page numbers will be inserted here by JavaScript -->
                <li class="page-item" id="nextPage">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
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
                    <p class="text-muted mb-0">You are about to delete <strong id="deleteCount"></strong> product(s). This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-2"></i>Delete Product(s)
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Stock management functionality
let selectedStockId = null;
let selectedStockName = null;
const stockDropdownElement = document.getElementById('stockDropdown');
const stockDropdown = new bootstrap.Dropdown(stockDropdownElement);

// Handle stock selection from dropdown
document.querySelectorAll('.dropdown-item[data-stock-id]').forEach(item => {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        selectedStockId = this.getAttribute('data-stock-id');
        selectedStockName = this.getAttribute('data-stock-name');
        
        // Update the dropdown button text
        stockDropdownElement.innerHTML = selectedStockName + ' <span class="caret"></span>';
        
        // Enable apply button
        document.getElementById('applyStock').disabled = false;
        
        // Close the dropdown
        stockDropdown.hide();
    });
});

// Handle apply button click
document.getElementById('applyStock').addEventListener('click', function() {
    if (!selectedStockId) {
        alert("Please select a stock first");
        return;
    }
    
    // Get all selected products
    const selectedCheckboxes = document.querySelectorAll('.productCheckbox:checked');
    const productIds = Array.from(selectedCheckboxes).map(checkbox => checkbox.value);
    
    if (productIds.length === 0) {
        alert("Please select at least one product");
        return;
    }
    
    // Confirm with user
    if (!confirm(`Assign ${productIds.length} product(s) to ${selectedStockName}?`)) {
        return;
    }
    
    // Show loading state
    const applyBtn = document.getElementById('applyStock');
    const originalText = applyBtn.innerHTML;
    applyBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Applying...';
    applyBtn.disabled = true;
    
    // Send data to server
    fetch('/products/assign-stock', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product_ids: productIds,
            stock_id: selectedStockId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(`Successfully assigned ${productIds.length} product(s) to ${selectedStockName}`);
            // Refresh the page to show changes
            location.reload();
        } else {
            alert("Failed to assign products: " + (data.message || "Unknown error"));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("An error occurred while assigning products");
    })
    .finally(() => {
        applyBtn.innerHTML = originalText;
        applyBtn.disabled = false;
    });
});

// Handle clear selection
document.getElementById('clearStockSelection').addEventListener('click', function() {
    selectedStockId = null;
    selectedStockName = null;
    stockDropdownElement.innerHTML = 'Select Stock <span class="caret"></span>';
    document.getElementById('applyStock').disabled = true;
});

// Pagination variables
const itemsPerPage = 6;
let currentPage = 1;
const totalItems = <?= count($products) ?>;
const totalPages = Math.ceil(totalItems / itemsPerPage);

// Initialize pagination
function initPagination() {
    const pagination = document.querySelector('.pagination');
    const prevPage = document.getElementById('prevPage');
    const nextPage = document.getElementById('nextPage');
    
    // Clear existing page numbers (except prev/next)
    const pageItems = document.querySelectorAll('.page-item:not(#prevPage):not(#nextPage)');
    pageItems.forEach(item => item.remove());
    
    // Add page numbers
    for (let i = 1; i <= totalPages; i++) {
        const pageItem = document.createElement('li');
        pageItem.className = `page-item ${i === 1 ? 'active' : ''}`;
        pageItem.innerHTML = `<a class="page-link" href="#">${i}</a>`;
        
        // Insert before next button
        nextPage.parentNode.insertBefore(pageItem, nextPage);
        
        // Add click event
        pageItem.addEventListener('click', function(e) {
            e.preventDefault();
            goToPage(i);
        });
    }
    
    // Update prev/next buttons
    prevPage.classList.toggle('disabled', currentPage === 1);
    nextPage.classList.toggle('disabled', currentPage === totalPages);
    
    // Add event listeners
    prevPage.addEventListener('click', function(e) {
        if (currentPage > 1) {
            e.preventDefault();
            goToPage(currentPage - 1);
        }
    });
    
    nextPage.addEventListener('click', function(e) {
        if (currentPage < totalPages) {
            e.preventDefault();
            goToPage(currentPage + 1);
        }
    });
}

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
document.addEventListener('DOMContentLoaded', function() {
    initPagination();
    goToPage(1);
    
    // Existing search functionality
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#productTableBody tr');

        rows.forEach(row => {
            const name = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            const description = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
            const price = row.querySelector('td:nth-child(6)').textContent; 
            const unit = row.querySelector('td:nth-child(7)').textContent; 
            const quantity = row.querySelector('td:nth-child(8)').textContent; 
            const stock = row.querySelector('td:nth-child(9)').textContent; 

            if (
                name.includes(searchValue) || 
                description.includes(searchValue) ||
                price.includes(this.value) || 
                unit.includes(this.value) || 
                quantity.includes(this.value) ||
                stock.includes(searchValue)
            ) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Existing import functionality
    document.getElementById('importProductsButton').addEventListener('click', function() {
        document.getElementById('excelFileInput').click();
    });

    document.getElementById('excelFileInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, { type: 'array' });

            const sheetName = workbook.SheetNames[0];
            const sheet = workbook.Sheets[sheetName];
            const jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

            const formattedData = jsonData.slice(1).map(row => ({
                image: row[0] || "", 
                name: row[1] || "",
                description: row[2] || "",
                price: parseFloat(row[3]) || 0,
                unit: row[4] || "",
                quantity: parseInt(row[5]) || 0
            }));

            fetch('/products/import', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ products: formattedData })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Products imported successfully!");
                    location.reload();
                } else {
                    alert("Failed to import products.");
                }
            })
            .catch(error => console.error('Error:', error));
        };
        reader.readAsArrayBuffer(file);
    });

    // Select all checkboxes
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.productCheckbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Delete selected products
    document.getElementById('deleteSelected').addEventListener('click', function() {
        const selectedCheckboxes = document.querySelectorAll('.productCheckbox:checked');
        const productIds = Array.from(selectedCheckboxes).map(checkbox => checkbox.value);

        if (productIds.length === 0) {
            alert("Please select at least one product to delete.");
            return;
        }

        // Update modal content
        document.getElementById('deleteCount').textContent = productIds.length;
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = '/products/destroy/multiple';

        // Handle form submission
        deleteForm.onsubmit = function(e) {
            e.preventDefault();
            
            fetch('/products/destroy/multiple', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ product_ids: productIds })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || "Failed to delete selected products.");
                }
            })
            .catch(error => console.error('Error:', error));
        };
    });

    // search
    document.getElementById('searchInput').addEventListener('input', function() {
    const searchValue = this.value.trim().toLowerCase();
    const rows = document.querySelectorAll('#productTableBody tr');
    let hasMatches = false;

    // Remove any existing search empty state
    const existingSearchEmpty = document.querySelector('.search-empty-state');
    if (existingSearchEmpty) existingSearchEmpty.remove();

    // Hide the default empty state if visible
    const defaultEmptyState = document.querySelector('.empty-state');
    if (defaultEmptyState) defaultEmptyState.style.display = 'none';

    rows.forEach(row => {
        // Skip empty state rows
        if (row.classList.contains('empty-state') || row.classList.contains('search-empty-state')) {
            return;
        }

        // Get all searchable columns (adjust indices as needed)
        const productId = row.cells[0].textContent.toLowerCase();
        const productName = row.cells[1].textContent.toLowerCase();
        const price = row.cells[2].textContent.toLowerCase();
        const unit = row.cells[3].textContent.toLowerCase();
        const stockId = row.cells[4]?.textContent.toLowerCase() || '';
        const stockName = row.cells[5]?.textContent.toLowerCase() || '';

        // Check if any field matches search
        const isMatch = searchValue === '' || 
                        productId.includes(searchValue) ||
                        productName.includes(searchValue) ||
                        price.includes(searchValue) ||
                        unit.includes(searchValue) ||
                        stockId.includes(searchValue) ||
                        stockName.includes(searchValue);

        // Toggle row visibility
        row.style.display = isMatch ? '' : 'none';
        
        // Track if we have any matches
        if (isMatch) hasMatches = true;
    });

    // Show appropriate empty state
    if (searchValue === '') {
        // If search is empty, show default empty state if no products
        if (defaultEmptyState && rows.length === 1) {
            defaultEmptyState.style.display = '';
        }
    } else if (!hasMatches) {
        // Show search-specific empty state
        const emptyRow = document.createElement('tr');
        emptyRow.className = 'search-empty-state';
        emptyRow.innerHTML = `
            <td colspan="${rows[0]?.cells.length || 7}" class="text-center">
                <i class="bi bi-search" style="font-size: 3rem; color: #adb5bd;"></i>
                <p class="mt-2 mb-0">No products match your search criteria</p>
            </td>
        `;
        document.getElementById('productTableBody').appendChild(emptyRow);
    }

    // Update pagination/showing text
    updateShowingText(hasMatches ? document.querySelectorAll('#productTableBody tr:not([style*="display: none"]):not(.empty-state):not(.search-empty-state)').length : 0);
});

function updateShowingText(visibleCount) {
    document.getElementById('showingFrom').textContent = visibleCount > 0 ? '1' : '0';
    document.getElementById('showingTo').textContent = visibleCount;
    document.getElementById('totalItems').textContent = visibleCount;
    
    // Hide pagination when searching (optional)
    if (document.getElementById('searchInput').value.trim() !== '') {
        document.querySelector('.pagination').style.display = 'none';
    } else {
        document.querySelector('.pagination').style.display = '';
    }
}
    
    
});
</script>
</body>
</html>