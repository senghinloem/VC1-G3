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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">`
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Container styling */
        .container {
            padding: 2rem;
            margin-top: -1.5rem;
        }

        /* Header section styling */
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            border: none; 
            border-radius: 6px 6px 0 0; 
            background: #ffffff; 
            padding: 1rem 1.5rem; 
            margin-top: -3.5rem;
            box-shadow: rgba(17, 17, 26, 0.05) 0px 1px 0px, rgba(17, 17, 26, 0.1) 0px 0px 8px;
        }

        /* Ensure header stays fixed */
        .header-section {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: white;
            padding: 1rem 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Maintain table structure */
        .table-responsive {
            min-height: 300px;
            position: relative;
        }

        /* Empty states positioning */
        .empty-state, .search-empty-state {
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            transform: translateY(-50%);
            text-align: center;
            background: transparent !important;
        }

        .header-section h4 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            display: flex;
            align-items: center;
        }

        .header-section h4 i {
            margin-right: 0.5rem;
            color: #0d6efd;
        }

        .header-section .search-container {
            flex-grow: 1;
            margin: 0 1rem;
        }

        .header-section .button-group {
            display: flex;
            gap: 0.5rem;
        }

        /* Button styling */
        .btn {
            border-radius: 4px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
            text-transform: uppercase;
        }

        .btn-primary {
            background: #0d6efd;
            border: none;
            color: #fff;
        }

        .btn-primary:hover {
            background: #0b5ed7;
        }

        .btn-dark {
            background: #212529;
            border: none;
            color: #fff;
        }

        .btn-dark:hover {
            background: #1c2526;
        }

        .btn-danger {
            background: #dc3545;
            border: none;
            color: #fff;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        /* Input group styling */
        .input-group {
            border-radius: 4px;
        }

        .form-control {
            border: 1px solid #ced4da;
            padding: 0.5rem 1rem;
            font-size: 0.95rem;
        }

        .btn-outline-secondary {
            border: 1px solid #ced4da;
            color: #6c757d;
        }

        .btn-outline-secondary:hover {
            background: #f8f9fa;
            color: #0d6efd;
        }

        /* Search loading state */
        .search-container .spinner {
            display: none;
            margin-left: 100px;
            color: #0d6efd;
        }

        .search-container.loading .spinner {
            display: inline-block;
        }

        /* Stat cards */
        .stat-card {
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            height: 100%;
        }

        .stat-card h3 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: #2c3e50;
        }

        .stat-card p {
            margin-bottom: 0;
            color: #6c757d;
            font-weight: 500;
        }

        .stat-card.total-users {
            background-color: #e3f2fd;
        }

        .stat-card.online-users {
            background-color: #e8f5e9;
        }

        .stat-card.offline-users {
            background-color: #ffebee;
        }

        .stat-card.online-rate {
            background-color: #fff8e1;
        }

        /* Table container */
        .table-responsive {
            overflow-x: auto;
            background: #fff;
            min-height: 200px;
        }

        /* Table styling */
        .table {
            margin-bottom: 0;
            width: 100%;
            min-width: 600px;
            border-collapse: collapse;
            background-color: #ffffff;
        }

        .table th {
            background: #f1f3f5;
            font-weight: 600;
            color: #2c3e50;
            padding: 12px 16px;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
            white-space: nowrap;
            text-align: start;
        }

        .table td {
            vertical-align: middle;
            padding: 10px 15px;
            color: #495057;
            border-bottom: 1px solid #eceff1;
            white-space: nowrap;
        }

        .table tbody tr {
            background-color: #fff;
        }

        .table tbody tr:hover {
            background-color: #f1f3f5;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Product column styling */
        .product-cell {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
        }

        .product-cell .product-name-box {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 5px 10px;
            width: 200px;
            background: #fff;
            overflow-x: auto;
            white-space: nowrap;
            display: inline-block;
            line-height: 1.5;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .product-cell .product-name-box::-webkit-scrollbar {
            display: none;
        }

        .input-group {
            width: 250px;
            margin-left: auto
        }

        .default-product-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #9aa8b8;
            font-size: 14px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            gap: 4px;
        }

        .default-product-image:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* Action buttons container */
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            align-items: center;
        }

        /* Dropdown styling */
        .dropdown-menu {
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .dropdown-item:hover {
            background-color: #e9ecef;
        }

        /* Text center for empty state */
        .text-center {
            padding: 40px 0;
            color: #6c757d;
            font-size: 1.1rem;
        }

        /* Modal image gallery */
        .image-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .image-gallery img {
            width: 10px;
            height: 10px;
            border-radius: 4px;
        }

        /* Pagination styling */
        .pagination {
            margin: 0;
        }

        .page-item.active .page-link {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .page-link {
            color: #0d6efd;
            border: 1px solid #dee2e6;
            padding: 0.5rem 0.75rem;
        }

        .page-link:hover {
            color: #0a58ca;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        /* Adding modal-specific styles */
        .modal-content {
            border: none;
            border-radius: 12px;
        }

        .modal-header {
            border-bottom: 1px solid rgba(0,0,0,0.08);
        }

        .modal-footer {
            border-top: 1px solid rgba(0,0,0,0.08);
        }

        /* Loading spinner styles */
        .btn .spinner-border {
            vertical-align: text-top;
            margin-right: 5px;
        }

        #applyStock:disabled {
            opacity: 0.7;
        }

        /* Add to your existing styles */
        .no-results td {
            padding: 40px 0 !important;
            color: #6c757d;
            font-size: 1.1rem;
            font-style: italic;
        }

        /* Make sure the "no products" message is centered */
        .text-center {
            text-align: center !important;
        }

        .empty-state td, 
        .search-empty-state td {
            padding: 3rem 1rem !important;
            text-align: center !important;
            border: none !important;
            background: transparent !important;
            text-align: center !important;
            vertical-align: middle !important; 
            position: relative;
            left: 160%;
        }

        .empty-state td:hover,
        .search-empty-state td:hover {
            background: transparent !important;
            color: inherit !important;
            cursor: default !important;
            box-shadow: none !important;
            text-decoration: none !important;
        }
                
        .empty-state i,
        .search-empty-state i {
            opacity: 0.5;
        }

        .empty-state p,
        .search-empty-state p {
            color: #6c757d;
            font-size: 1.1rem;
        }
        
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .product-cell .product-name-box {
                width: 150px;
            }
            .table th,
            .table td {
                padding: 8px 10px;
            }

            .btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.9rem;
            }

            .stat-card h3 {
                font-size: 1.5rem;
            }

            .stat-card p {
                font-size: 0.9rem;
            }

            .header-section {
                flex-wrap: wrap;
                gap: 1rem;
            }

            .header-section .search-container {
                flex-grow: 1;
                margin: 0;
                width: 100%;
            }

            .header-section .button-group {
                width: 100%;
                justify-content: flex-end;
            }
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <!-- Header Section -->
    <div class="header-section">
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
                    <h3><?= number_format($totalProducts ?? 0) ?></h3>
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
                                <img class="default-product-image" src="<?= htmlspecialchars($product['image']) ?>" alt="no image" style="width: 80px; height: 80px;">
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
const itemsPerPage = 10;
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
    if (!file) {
        alert("No file selected. Please select an Excel or CSV file to import.");
        return;
    }

    const validExtensions = ['.xlsx', '.xls', '.csv'];
    const fileExtension = file.name.slice(file.name.lastIndexOf('.')).toLowerCase();
    if (!validExtensions.includes(fileExtension)) {
        alert("Invalid file type. Please upload a valid Excel or CSV file (.xlsx, .xls, or .csv).");
        return;
    }

    if (typeof XLSX === 'undefined') {
        alert("Failed to load the Excel/CSV processing library. Please check your internet connection and try again.");
        return;
    }

    // Show loading state
    const importButton = document.getElementById('importProductsButton');
    const originalButtonText = importButton.innerHTML;
    importButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Importing...';
    importButton.disabled = true;

    const reader = new FileReader();

    // Handle CSV
    if (fileExtension === '.csv') {
        reader.onload = function(e) {
            try {
                const text = e.target.result;
                // Parse CSV using XLSX library
                const workbook = XLSX.read(text, { type: 'string', raw: true });
                
                if (!workbook.SheetNames.length) {
                    alert("The CSV file is empty or invalid. Please upload a valid file with product data.");
                    return;
                }

                const sheetName = workbook.SheetNames[0];
                const sheet = workbook.Sheets[sheetName];
                const jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

                if (jsonData.length < 2) {
                    alert("The CSV file is empty or does not contain product data (at least one row of data is required after the header).");
                    return;
                }

                const expectedHeaders = ['Image', 'Name', 'Description', 'Price', 'Unit', 'Quantity'];
                const headers = jsonData[0];
                const missingHeaders = expectedHeaders.filter((header, index) => !headers[index] || headers[index].toLowerCase() !== header.toLowerCase());
                if (missingHeaders.length > 0) {
                    alert(`The CSV file header is incorrect. Expected columns: ${expectedHeaders.join(', ')}. Please fix the header and try again.`);
                    return;
                }

                const formattedData = jsonData.slice(1).map((row, index) => {
                    const product = {
                        image: row[0] || "",
                        name: row[1] || "",
                        description: row[2] || "",
                        price: parseFloat(row[3]) || 0,
                        unit: row[4] || "",
                        quantity: parseInt(row[5]) || 0
                    };

                    if (!product.name) {
                        throw new Error(`Row ${index + 2}: Product name is required.`);
                    }
                    if (isNaN(product.price) || product.price < 0) {
                        throw new Error(`Row ${index + 2}: Price must be a valid non-negative number.`);
                    }
                    if (isNaN(product.quantity) || product.quantity < 0) {
                        throw new Error(`Row ${index + 2}: Quantity must be a valid non-negative integer.`);
                    }

                    return product;
                });

                if (formattedData.length === 0) {
                    alert("No valid products found in the CSV file to import.");
                    return;
                }

                console.log("Formatted Data (CSV):", formattedData);

                fetch('/products/import', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ products: formattedData })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Server responded with status ${response.status}: ${response.statusText}`);
                    }
                    const contentType = response.headers.get('Content-Type');
                    if (!contentType || !contentType.includes('application/json')) {
                        return response.text().then(text => {
                            throw new Error(`Expected JSON, but received: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert(data.message || "Products imported successfully!");
                        location.reload();
                    } else {
                        alert(`Failed to import products: ${data.message || "Unknown error"}\n${data.errors ? data.errors.join('\n') : ''}`);
                    }
                })
                .catch(error => {
                    console.error('Error during CSV import:', error);
                    alert(`An error occurred while importing products: ${error.message}`);
                })
                .finally(() => {
                    importButton.innerHTML = originalButtonText;
                    importButton.disabled = false;
                });
            } catch (error) {
                console.error('Error reading CSV file:', error);
                alert(`Failed to process the CSV file: ${error.message}`);
                importButton.innerHTML = originalButtonText;
                importButton.disabled = false;
            }
        };
        reader.onerror = function() {
            alert("Failed to read the CSV file. Please ensure the file is not corrupted and try again.");
            importButton.innerHTML = originalButtonText;
            importButton.disabled = false;
        };
        reader.readAsText(file); // Read as text for CSV
    }
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

// Search functionality with proper field matching
document.getElementById('searchInput').addEventListener('input', function() {
    const searchValue = this.value.trim().toLowerCase();
    const allRows = document.querySelectorAll('#productTableBody tr');
    const productRows = Array.from(allRows).filter(row => 
        !row.classList.contains('empty-state') && 
        !row.classList.contains('search-empty-state')
    );
    let hasMatches = false;
    const previousPage = currentPage;
    const defaultEmptyState = document.querySelector('.empty-state');

    // Clear previous empty states
    const existingEmpty = document.querySelector('.search-empty-state');
    if (existingEmpty) existingEmpty.remove();

    // Hide default empty state if visible
    if (defaultEmptyState) defaultEmptyState.style.display = 'none';

    // Search through products
    productRows.forEach(row => {
        const cells = row.cells;
        const rowData = [
            cells[2]?.textContent.toLowerCase() || '', // Name
            cells[3]?.textContent.toLowerCase() || '', // Description
            cells[4]?.textContent.toLowerCase() || '', // Barcode
            cells[5]?.textContent.toLowerCase() || '', // Price
            cells[6]?.textContent.toLowerCase() || '', // Unit
            cells[7]?.textContent.toLowerCase() || ''  // Quantity
        ].join(' ');

        const isMatch = searchValue === '' || rowData.includes(searchValue);
        row.style.display = isMatch ? '' : 'none';
        if (isMatch) hasMatches = true;
    });

    // Handle empty states without affecting layout
    if (searchValue === '') {
        if (productRows.length === 0 && defaultEmptyState) {
            defaultEmptyState.style.display = '';
        }
        currentPage = previousPage;
    } else if (!hasMatches) {
        const emptyRow = document.createElement('tr');
        emptyRow.className = 'search-empty-state';
        emptyRow.innerHTML = `
            <td colspan="8" class="text-center" ">
                <i class="bi bi-search" style="font-size: 3rem; color: #adb5bd;"></i>
                <p class="mt-2 mb-0">No products match your search</p>
            </td>
        `;
        document.getElementById('productTableBody').appendChild(emptyRow);
    }

    // Maintain layout consistency (critical for single product case)
    const tableResponsive = document.querySelector('.table-responsive');
    tableResponsive.style.minHeight = '300px';
    
    // Ensure header stays at top (add this to your CSS if not present)
    const headerSection = document.querySelector('.header-section');
    headerSection.style.position = 'sticky';
    headerSection.style.top = '0';
    headerSection.style.zIndex = '1000';
    headerSection.style.background = 'white';

    // Update pagination (existing functionality)
    updatePaginationAfterSearch(hasMatches, searchValue);

    // Special case: When only one product matches
    if (hasMatches && document.querySelectorAll('#productTableBody tr[style=""]').length === 1) {
        // Keep the same layout as normal
        tableResponsive.style.minHeight = '300px';
    }
});


// Update pagination after search
function updatePaginationAfterSearch(hasMatches, searchValue) {
    // Count visible rows (excluding empty states)
    const visibleRows = document.querySelectorAll('#productTableBody tr:not([style*="display: none"]):not(.empty-state):not(.search-empty-state)');
    const visibleCount = visibleRows.length;
    const totalFilteredPages = Math.ceil(visibleCount / itemsPerPage);

    // Adjust current page if it's now invalid
    if (currentPage > totalFilteredPages && totalFilteredPages > 0) {
        currentPage = totalFilteredPages;
    } else if (totalFilteredPages === 0) {
        currentPage = 1;
    }

    // Update showing text
    const startIndex = (currentPage - 1) * itemsPerPage + 1;
    const endIndex = Math.min(currentPage * itemsPerPage, visibleCount);
    
    document.getElementById('showingFrom').textContent = visibleCount > 0 ? startIndex : '0';
    document.getElementById('showingTo').textContent = visibleCount > 0 ? endIndex : '0';
    document.getElementById('totalItems').textContent = visibleCount;

    // Reinitialize pagination controls
    initPagination();
    
    // Show the appropriate rows for the current page
    if (searchValue === '') {
        // If no search, show all products with normal pagination
        goToPage(currentPage);
    } else if (hasMatches) {
        // If search has matches, show filtered results with pagination
        renderFilteredProducts();
    }
}

// Render filtered products with pagination
function renderFilteredProducts() {
    const visibleRows = Array.from(document.querySelectorAll('#productTableBody tr:not([style*="display: none"]):not(.empty-state):not(.search-empty-state)'));
    
    // Hide all products first
    document.querySelectorAll('#productTableBody tr').forEach(row => {
        row.style.display = 'none';
    });
    
    // Calculate range for current page
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = Math.min(startIndex + itemsPerPage, visibleRows.length);
    
    // Show products for current page
    for (let i = startIndex; i < endIndex; i++) {
        if (visibleRows[i]) {
            visibleRows[i].style.display = '';
        }
    }
}
    
    
});
</script>
</body>
</html>