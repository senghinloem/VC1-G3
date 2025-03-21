<!-- Inventory Reports Page Content -->
<div class="container-fluid px-4 py-3">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1">Reports & Analytics</h1>
            <p class="text-muted mb-0">Generate and analyze inventory data reports</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" id="scheduleReportBtn">
                <i class="fas fa-clock me-2"></i>Schedule Reports
            </button>
            <button class="btn btn-primary" id="createReportBtn">
                <i class="fas fa-plus me-2"></i>Create Report
            </button>
        </div>
    </div>
    
    <!-- Report Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                        <i class="fas fa-box text-primary fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Total Products</h6>
                        <h3 class="mb-0">1,248</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                        <i class="fas fa-dollar-sign text-success fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Inventory Value</h6>
                        <h3 class="mb-0">$842,567</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                        <i class="fas fa-exclamation-triangle text-warning fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Low Stock Items</h6>
                        <h3 class="mb-0">42</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                        <i class="fas fa-exchange-alt text-info fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1">Monthly Turnover</h6>
                        <h3 class="mb-0">24.7%</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Report Categories and Filters -->
    <div class="row mb-4">
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Report Categories</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action active d-flex align-items-center">
                            <i class="fas fa-chart-line me-3"></i>
                            <span>Overview Dashboard</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-boxes me-3"></i>
                            <span>Inventory Status</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-exchange-alt me-3"></i>
                            <span>Stock Movement</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-shopping-cart me-3"></i>
                            <span>Sales Analysis</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-star me-3"></i>
                            <span>Product Performance</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-truck me-3"></i>
                            <span>Supplier Analysis</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-warehouse me-3"></i>
                            <span>Location Reports</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="fas fa-dollar-sign me-3"></i>
                            <span>Valuation Reports</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Filters</h5>
                    <button class="btn btn-sm btn-outline-secondary">Reset</button>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Date Range</label>
                        <select class="form-select mb-2">
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="last7">Last 7 Days</option>
                            <option value="last30" selected>Last 30 Days</option>
                            <option value="thisMonth">This Month</option>
                            <option value="lastMonth">Last Month</option>
                            <option value="custom">Custom Range</option>
                        </select>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="date" class="form-control form-control-sm" value="2025-02-21">
                            </div>
                            <div class="col-6">
                                <input type="date" class="form-control form-control-sm" value="2025-03-21">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Locations</label>
                        <select class="form-select" multiple size="3">
                            <option value="all" selected>All Locations</option>
                            <option value="main">Main Warehouse</option>
                            <option value="east">East Coast Fulfillment</option>
                            <option value="west">West Storage</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Product Categories</label>
                        <select class="form-select" multiple size="3">
                            <option value="all" selected>All Categories</option>
                            <option value="electronics">Electronics</option>
                            <option value="clothing">Clothing</option>
                            <option value="home">Home Goods</option>
                            <option value="office">Office Supplies</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Stock Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="inStock" checked>
                            <label class="form-check-label" for="inStock">In Stock</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="lowStock" checked>
                            <label class="form-check-label" for="lowStock">Low Stock</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="outOfStock" checked>
                            <label class="form-check-label" for="outOfStock">Out of Stock</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="overstock" checked>
                            <label class="form-check-label" for="overstock">Overstock</label>
                        </div>
                    </div>
                    
                    <button class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Apply Filters
                    </button>
                </div>
            </div>
        </div>
        
        <div class="col-lg-9">
            <!-- Report Header -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">Inventory Overview Dashboard</h4>
                        <div class="btn-group">
                            <button class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-print me-1"></i> Print
                            </button>
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-download me-1"></i> Export
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="far fa-file-pdf me-2"></i>PDF</a></li>
                                <li><a class="dropdown-item" href="#"><i class="far fa-file-excel me-2"></i>Excel</a></li>
                                <li><a class="dropdown-item" href="#"><i class="far fa-file-csv me-2"></i>CSV</a></li>
                            </ul>
                            <button class="btn btn-outline-secondary btn-sm">
                                <i class="far fa-star me-1"></i> Save
                            </button>
                        </div>
                    </div>
                    <p class="text-muted">
                        Showing data for <strong>Last 30 Days</strong> (Feb 21, 2025 - Mar 21, 2025) • All Locations • All Categories
                    </p>
                </div>
            </div>
            
            <!-- Charts Row -->
            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Inventory Value Trend</h5>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                    Last 30 Days
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                                    <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                                    <li><a class="dropdown-item" href="#">Last 90 Days</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="inventoryValueChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Stock Status Distribution</h5>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                    All Categories
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">All Categories</a></li>
                                    <li><a class="dropdown-item" href="#">Electronics</a></li>
                                    <li><a class="dropdown-item" href="#">Clothing</a></li>
                                    <li><a class="dropdown-item" href="#">Home Goods</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="stockStatusChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-8 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Stock Movement</h5>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                    Last 30 Days
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                                    <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                                    <li><a class="dropdown-item" href="#">Last 90 Days</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="stockMovementChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Inventory by Location</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="locationChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Top Products Table -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Top Products by Value</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                            Top 10
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Top 5</a></li>
                            <li><a class="dropdown-item" href="#">Top 10</a></li>
                            <li><a class="dropdown-item" href="#">Top 20</a></li>
                            <li><a class="dropdown-item" href="#">All Products</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>SKU</th>
                                    <th>Category</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end">Unit Cost</th>
                                    <th class="text-end">Total Value</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Premium Wireless Headphones</td>
                                    <td>EL-1001</td>
                                    <td>Electronics</td>
                                    <td class="text-center">124</td>
                                    <td class="text-end">$89.99</td>
                                    <td class="text-end">$11,158.76</td>
                                    <td class="text-center"><span class="badge bg-success">In Stock</span></td>
                                </tr>
                                <tr>
                                    <td>Ultra HD Smart TV 55"</td>
                                    <td>EL-2045</td>
                                    <td>Electronics</td>
                                    <td class="text-center">18</td>
                                    <td class="text-end">$549.99</td>
                                    <td class="text-end">$9,899.82</td>
                                    <td class="text-center"><span class="badge bg-success">In Stock</span></td>
                                </tr>
                                <tr>
                                    <td>Professional DSLR Camera</td>
                                    <td>EL-3078</td>
                                    <td>Electronics</td>
                                    <td class="text-center">12</td>
                                    <td class="text-end">$799.99</td>
                                    <td class="text-end">$9,599.88</td>
                                    <td class="text-center"><span class="badge bg-warning text-dark">Low Stock</span></td>
                                </tr>
                                <tr>
                                    <td>Designer Leather Sofa</td>
                                    <td>HG-5023</td>
                                    <td>Home Goods</td>
                                    <td class="text-center">8</td>
                                    <td class="text-end">$1,199.99</td>
                                    <td class="text-end">$9,599.92</td>
                                    <td class="text-center"><span class="badge bg-success">In Stock</span></td>
                                </tr>
                                <tr>
                                    <td>Premium Smartphone</td>
                                    <td>EL-1089</td>
                                    <td>Electronics</td>
                                    <td class="text-center">15</td>
                                    <td class="text-end">$599.99</td>
                                    <td class="text-end">$8,999.85</td>
                                    <td class="text-center"><span class="badge bg-success">In Stock</span></td>
                                </tr>
                                <tr>
                                    <td>Ergonomic Office Chair</td>
                                    <td>OF-2034</td>
                                    <td>Office Supplies</td>
                                    <td class="text-center">32</td>
                                    <td class="text-end">$249.99</td>
                                    <td class="text-end">$7,999.68</td>
                                    <td class="text-center"><span class="badge bg-info">Overstock</span></td>
                                </tr>
                                <tr>
                                    <td>Luxury Watch Collection</td>
                                    <td>AC-7812</td>
                                    <td>Accessories</td>
                                    <td class="text-center">9</td>
                                    <td class="text-end">$799.99</td>
                                    <td class="text-end">$7,199.91</td>
                                    <td class="text-center"><span class="badge bg-warning text-dark">Low Stock</span></td>
                                </tr>
                                <tr>
                                    <td>Gaming Laptop Pro</td>
                                    <td>EL-4056</td>
                                    <td>Electronics</td>
                                    <td class="text-center">6</td>
                                    <td class="text-end">$1,199.99</td>
                                    <td class="text-end">$7,199.94</td>
                                    <td class="text-center"><span class="badge bg-warning text-dark">Low Stock</span></td>
                                </tr>
                                <tr>
                                    <td>Premium Coffee Maker</td>
                                    <td>HG-3045</td>
                                    <td>Home Goods</td>
                                    <td class="text-center">28</td>
                                    <td class="text-end">$249.99</td>
                                    <td class="text-end">$6,999.72</td>
                                    <td class="text-center"><span class="badge bg-success">In Stock</span></td>
                                </tr>
                                <tr>
                                    <td>Wireless Earbuds Pro</td>
                                    <td>EL-1056</td>
                                    <td>Electronics</td>
                                    <td class="text-center">45</td>
                                    <td class="text-end">$149.99</td>
                                    <td class="text-end">$6,749.55</td>
                                    <td class="text-center"><span class="badge bg-success">In Stock</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white py-2">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            
            <!-- Alerts and Recommendations -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">Alerts & Recommendations</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning d-flex align-items-center mb-3" role="alert">
                        <i class="fas fa-exclamation-triangle me-3 fa-lg"></i>
                        <div>
                            <strong>42 products</strong> are currently at low stock levels. <a href="#" class="alert-link">View details</a>
                        </div>
                    </div>
                    <div class="alert alert-danger d-flex align-items-center mb-3" role="alert">
                        <i class="fas fa-times-circle me-3 fa-lg"></i>
                        <div>
                            <strong>15 products</strong> are out of stock. <a href="#" class="alert-link">View details</a>
                        </div>
                    </div>
                    <div class="alert alert-info d-flex align-items-center mb-3" role="alert">
                        <i class="fas fa-info-circle me-3 fa-lg"></i>
                        <div>
                            <strong>8 products</strong> have been overstocked for more than 60 days. Consider running promotions. <a href="#" class="alert-link">View details</a>
                        </div>
                    </div>
                    <div class="alert alert-success d-flex align-items-center mb-0" role="alert">
                        <i class="fas fa-lightbulb me-3 fa-lg"></i>
                        <div>
                            Based on current sales trends, we recommend increasing stock for <strong>Premium Wireless Headphones</strong> by 20%. <a href="#" class="alert-link">View analysis</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Saved Reports -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Saved & Scheduled Reports</h5>
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-plus me-1"></i> New Report
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Report Name</th>
                                    <th>Type</th>
                                    <th>Last Generated</th>
                                    <th>Schedule</th>
                                    <th>Recipients</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Monthly Inventory Valuation</td>
                                    <td>Valuation</td>
                                    <td>Mar 01, 2025</td>
                                    <td>Monthly (1st)</td>
                                    <td>3 recipients</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-secondary me-1">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Weekly Stock Movement</td>
                                    <td>Stock Movement</td>
                                    <td>Mar 18, 2025</td>
                                    <td>Weekly (Mon)</td>
                                    <td>2 recipients</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-secondary me-1">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Low Stock Alert Report</td>
                                    <td>Inventory Status</td>
                                    <td>Mar 21, 2025</td>
                                    <td>Daily</td>
                                    <td>4 recipients</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-secondary me-1">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Quarterly Product Performance</td>
                                    <td>Product Performance</td>
                                    <td>Jan 05, 2025</td>
                                    <td>Quarterly</td>
                                    <td>5 recipients</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-secondary me-1">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary me-1">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Report Modal -->
<div class="modal fade" id="createReportModal" tabindex="-1" aria-labelledby="createReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createReportModalLabel">Create New Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Report Name</label>
                    <input type="text" class="form-control" placeholder="Enter report name">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Report Type</label>
                    <select class="form-select">
                        <option value="">Select report type</option>
                        <option value="inventory">Inventory Status</option>
                        <option value="movement">Stock Movement</option>
                        <option value="sales">Sales Analysis</option>
                        <option value="performance">Product Performance</option>
                        <option value="supplier">Supplier Analysis</option>
                        <option value="location">Location Reports</option>
                        <option value="valuation">Valuation Reports</option>
                    </select>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Date Range</label>
                        <select class="form-select mb-2">
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="last7">Last 7 Days</option>
                            <option value="last30" selected>Last 30 Days</option>
                            <option value="thisMonth">This Month</option>
                            <option value="lastMonth">Last Month</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Format</label>
                        <select class="form-select">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                            <option value="csv">CSV</option>
                            <option value="html">HTML</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Include Sections</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="includeSummary" checked>
                        <label class="form-check-label" for="includeSummary">Summary</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="includeCharts" checked>
                        <label class="form-check-label" for="includeCharts">Charts & Graphs</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="includeDetails" checked>
                        <label class="form-check-label" for="includeDetails">Detailed Data</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="includeRecommendations" checked>
                        <label class="form-check-label" for="includeRecommendations">Recommendations</label>
                    </div>
                </div>
                
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="scheduleReport">
                    <label class="form-check-label" for="scheduleReport">Schedule this report</label>
                </div>
                
                <div class="row mb-3 schedule-options d-none">
                    <div class="col-md-6">
                        <label class="form-label">Frequency</label>
                        <select class="form-select">
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                            <option value="quarterly">Quarterly</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Recipients</label>
                        <select class="form-select" multiple>
                            <option value="1">John Doe (Inventory Manager)</option>
                            <option value="2">Jane Smith (Purchasing)</option>
                            <option value="3">Mike Johnson (Warehouse)</option>
                            <option value="4">Sarah Williams (Operations)</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Generate Report</button>
            </div>
        </div>
    </div>
</div>

<!-- Schedule Report Modal -->
<div class="modal fade" id="scheduleReportModal" tabindex="-1" aria-labelledby="scheduleReportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scheduleReportModalLabel">Schedule Reports</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Select Report</label>
                    <select class="form-select">
                        <option value="">Select a report to schedule</option>
                        <option value="1">Inventory Status Report</option>
                        <option value="2">Stock Movement Report</option>
                        <option value="3">Product Performance Report</option>
                        <option value="4">Valuation Report</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Frequency</label>
                    <select class="form-select" id="scheduleFrequency">
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                        <option value="quarterly">Quarterly</option>
                    </select>
                </div>
                
                <div class="mb-3 weekly-options d-none">
                    <label class="form-label">Day of Week</label>
                    <select class="form-select">
                        <option value="1">Monday</option>
                        <option value="2">Tuesday</option>
                        <option value="3">Wednesday</option>
                        <option value="4">Thursday</option>
                        <option value="5">Friday</option>
                        <option value="6">Saturday</option>
                        <option value="0">Sunday</option>
                    </select>
                </div>
                
                <div class="mb-3 monthly-options d-none">
                    <label class="form-label">Day of Month</label>
                    <select class="form-select">
                        <option value="1">1st</option>
                        <option value="15">15th</option>
                        <option value="last">Last day</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Time</label>
                    <input type="time" class="form-control" value="08:00">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Format</label>
                    <select class="form-select">
                        <option value="pdf">PDF</option>
                        <option value="excel">Excel</option>
                        <option value="csv">CSV</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Recipients</label>
                    <select class="form-select" multiple>
                        <option value="1">John Doe (Inventory Manager)</option>
                        <option value="2">Jane Smith (Purchasing)</option>
                        <option value="3">Mike Johnson (Warehouse)</option>
                        <option value="4">Sarah Williams (Operations)</option>
                    </select>
                    <div class="form-text">Hold Ctrl/Cmd to select multiple recipients</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Schedule Report</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Make sure Font Awesome is loaded
    if (typeof FontAwesome === 'undefined') {
        var link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css';
        document.head.appendChild(link);
    }
    
    // Initialize modals
    document.getElementById('createReportBtn').addEventListener('click', function() {
        var createReportModal = new bootstrap.Modal(document.getElementById('createReportModal'));
        createReportModal.show();
    });
    
    document.getElementById('scheduleReportBtn').addEventListener('click', function() {
        var scheduleReportModal = new bootstrap.Modal(document.getElementById('scheduleReportModal'));
        scheduleReportModal.show();
    });
    
    // Toggle schedule options
    document.getElementById('scheduleReport').addEventListener('change', function() {
        var scheduleOptions = document.querySelector('.schedule-options');
        if (this.checked) {
            scheduleOptions.classList.remove('d-none');
        } else {
            scheduleOptions.classList.add('d-none');
        }
    });
    
    // Toggle frequency options
    document.getElementById('scheduleFrequency').addEventListener('change', function() {
        var weeklyOptions = document.querySelector('.weekly-options');
        var monthlyOptions = document.querySelector('.monthly-options');
        
        weeklyOptions.classList.add('d-none');
        monthlyOptions.classList.add('d-none');
        
        if (this.value === 'weekly') {
            weeklyOptions.classList.remove('d-none');
        } else if (this.value === 'monthly' || this.value === 'quarterly') {
            monthlyOptions.classList.remove('d-none');
        }
    });
    
    // Initialize charts
    document.addEventListener('DOMContentLoaded', function() {
        // Inventory Value Trend Chart
        var inventoryValueCtx = document.getElementById('inventoryValueChart').getContext('2d');
        var inventoryValueChart = new Chart(inventoryValueCtx, {
            type: 'line',
            data: {
                labels: ['Feb 21', 'Feb 28', 'Mar 7', 'Mar 14', 'Mar 21'],
                datasets: [{
                    label: 'Inventory Value ($)',
                    data: [820000, 835000, 842000, 838000, 842567],
                    borderColor: '#4361ee',
                    backgroundColor: 'rgba(67, 97, 238, 0.1)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
        
        // Stock Status Chart
        var stockStatusCtx = document.getElementById('stockStatusChart').getContext('2d');
        var stockStatusChart = new Chart(stockStatusCtx, {
            type: 'doughnut',
            data: {
                labels: ['In Stock', 'Low Stock', 'Out of Stock', 'Overstock'],
                datasets: [{
                    data: [65, 15, 5, 15],
                    backgroundColor: [
                        '#198754',
                        '#ffc107',
                        '#dc3545',
                        '#0dcaf0'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
        
        // Stock Movement Chart
        var stockMovementCtx = document.getElementById('stockMovementChart').getContext('2d');
        var stockMovementChart = new Chart(stockMovementCtx, {
            type: 'bar',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [
                    {
                        label: 'Incoming',
                        data: [120, 85, 95, 130],
                        backgroundColor: '#4361ee'
                    },
                    {
                        label: 'Outgoing',
                        data: [95, 100, 80, 110],
                        backgroundColor: '#ff6b6b'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        stacked: false
                    },
                    y: {
                        stacked: false,
                        beginAtZero: true
                    }
                }
            }
        });
        
        // Location Chart
        var locationCtx = document.getElementById('locationChart').getContext('2d');
        var locationChart = new Chart(locationCtx, {
            type: 'pie',
            data: {
                labels: ['Main Warehouse', 'East Coast Fulfillment', 'West Storage'],
                datasets: [{
                    data: [60, 30, 10],
                    backgroundColor: [
                        '#4361ee',
                        '#3bc9db',
                        '#a3a1fb'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
</script>