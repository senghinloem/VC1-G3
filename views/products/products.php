<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory System Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Container styling */
        .container {
            padding: 1.5rem;
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
            width: 200px; /* Fixed width */
            background: #fff;
            overflow-x: auto; /* Enable scrolling */
            white-space: nowrap; /* Keep text on one line */
            display: inline-block;
            line-height: 1.5;
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .product-cell .product-name-box::-webkit-scrollbar {
            display: none;
        }
        /* Barcode search button - Updated to match the image */
        .barcode-search {
            display: flex;
            align-items: center;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 6px 12px;
            background: #fff;
            width: 220px; /* Slightly wider to accommodate spacing */
            cursor: pointer;
            height: 34px;
            justify-content: space-between; /* This will help separate text and icon */
        }

        .barcode-search .barcode-icon {
            color: #6c757d;
            font-size: 16px;
            margin-right: 8px;
        }

        .barcode-search .barcode-text {
            color: #6c757d;
            font-size: 12px;
            font-weight: 400;
            letter-spacing: 0.2px;
            white-space: nowrap;
            margin-right: 20px; /* Added space between text and search icon */
            flex-grow: 1; /* Allow text to take available space */
        }

        .barcode-search .search-icon {
            color: #6c757d;
            font-size: 14px;
            margin-left: 0; /* Reset margin since we're using justify-content: space-between */
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

        .image-placeholder-icon {
            filter: drop-shadow(0 1px 1px rgba(0,0,0,0.1));
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

        /* Adding modal-specific styles from user management */
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

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .product-cell .product-name-box {
                width: 150px; /* Adjust width for smaller screens */
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
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="input-group w-50">
            <input type="text" id="searchInput" class="form-control" placeholder="Search for product...">
            <button class="btn btn-outline-secondary" type="button">
                <i class="bi bi-search"></i>
            </button>
        </div>
        <div>
            <a href="/create" class="btn btn-primary">Add Product</a>
            
            <input type="file" id="excelFileInput" accept=".xlsx, .xls" style="display: none;">
            
            <button class="btn btn-dark" id="importProductsButton">Import Products</button>
        </div>
    </div>
    
    <h4>Products</h4>

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
            <?php foreach ($stocks as $stock): ?>
                <li><a class="dropdown-item" href="#" data-value="<?= htmlspecialchars($stock['stock_name']) ?>"><?= htmlspecialchars($stock['stock_name']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <button class="btn btn-apply" id="applyStock" style="background:green; color:white;">Apply</button>
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
                    <tr>
                        <td colspan="9" class="text-center">There are no products.</td>
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
// Pagination variables
const itemsPerPage = 8;
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

            if (
                name.includes(searchValue) || 
                description.includes(searchValue) ||
                price.includes(this.value) || 
                unit.includes(this.value) || 
                quantity.includes(this.value) 
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

    // Existing dropdown and image upload logic remains unchanged
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const value = this.getAttribute('data-value');
            const text = this.textContent;
            const dropdownButton = document.getElementById('stockDropdown');
            dropdownButton.textContent = text;
            dropdownButton.setAttribute('data-selected', value);
        });
    });

    document.querySelectorAll('[id^="addImageForm_"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('/products/add-image', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message || "Image added successfully!");
                    location.reload();
                } else {
                    alert(data.message || "Failed to add image.");
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
</script>
</body>
</html>