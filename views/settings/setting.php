<!-- <link rel="stylesheet" href="../../views/assets/css/setting.css">
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">Inventory Settings</h1>
    <div class="d-flex align-items-center">
        <button class="btn btn-outline-secondary me-3" id="themeToggle" title="Toggle Theme">
            <i class="fas fa-sun theme-icon"></i>
        </button>
        <button class="btn btn-primary" id="saveSettings">
            <i class="fas fa-save me-2"></i>Save Changes
        </button>
    </div>
</div>
<script>
const themeToggle = document.getElementById('themeToggle');
const themeIcon = themeToggle.querySelector('.theme-icon');
themeToggle.addEventListener('click', function() {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    if (currentTheme === 'light') {
        document.documentElement.removeAttribute('data-theme');
        themeIcon.classList.remove('fa-moon');
        themeIcon.classList.add('fa-sun');
        localStorage.setItem('theme', 'default');
    } else {
        document.documentElement.setAttribute('data-theme', 'light');
        themeIcon.classList.remove('fa-sun');
        themeIcon.classList.add('fa-moon');
        localStorage.setItem('theme', 'light');
    }
});
const savedTheme = localStorage.getItem('theme');
if (savedTheme === 'light') {
    document.documentElement.setAttribute('data-theme', 'light');
    themeIcon.classList.remove('fa-sun');
    themeIcon.classList.add('fa-moon');
}
</script>

 -->



<!-- Inventory Settings Page Content -->
<div class="container-fluid px-4 py-3">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Inventory Settings</h1>
        <button class="btn btn-primary" id="saveSettings">
            <i class="fas fa-save me-2"></i>Save Changes
        </button>
    </div>
    
    <!-- Settings Navigation Tabs -->
    <ul class="nav nav-tabs mb-4" id="settingsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">
                <i class="fas fa-cog me-2"></i>General
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="stock-tab" data-bs-toggle="tab" data-bs-target="#stock" type="button" role="tab" aria-controls="stock" aria-selected="false">
                <i class="fas fa-boxes me-2"></i>Stock Levels
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="locations-tab" data-bs-toggle="tab" data-bs-target="#locations" type="button" role="tab" aria-controls="locations" aria-selected="false">
                <i class="fas fa-warehouse me-2"></i>Locations
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" type="button" role="tab" aria-controls="notifications" aria-selected="false">
                <i class="fas fa-bell me-2"></i>Notifications
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="advanced-tab" data-bs-toggle="tab" data-bs-target="#advanced" type="button" role="tab" aria-controls="advanced" aria-selected="false">
                <i class="fas fa-sliders-h me-2"></i>Advanced
            </button>
        </li>
    </ul>
    
    <!-- Settings Content -->
    <div class="tab-content" id="settingsTabContent">
        <!-- General Settings -->
        <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Inventory Method</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Inventory Valuation Method</label>
                                <select class="form-select">
                                    <option value="fifo">FIFO (First In, First Out)</option>
                                    <option value="lifo">LIFO (Last In, First Out)</option>
                                    <option value="avg">Average Cost</option>
                                    <option value="specific">Specific Identification</option>
                                </select>
                                <div class="form-text text-muted">
                                    This affects how inventory costs are calculated when items are sold.
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Default Unit of Measurement</label>
                                <select class="form-select">
                                    <option value="piece">Piece</option>
                                    <option value="kg">Kilogram</option>
                                    <option value="liter">Liter</option>
                                    <option value="meter">Meter</option>
                                    <option value="box">Box</option>
                                </select>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="allowNegativeStock">
                                <label class="form-check-label" for="allowNegativeStock">Allow Negative Stock</label>
                                <div class="form-text text-muted">
                                    If enabled, products can be sold even when inventory shows zero stock.
                                </div>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="autoUpdateStock" checked>
                                <label class="form-check-label" for="autoUpdateStock">Automatically Update Stock on Sales</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Barcode Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Default Barcode Type</label>
                                <select class="form-select">
                                    <option value="code128">Code 128</option>
                                    <option value="ean13">EAN-13</option>
                                    <option value="upc">UPC</option>
                                    <option value="qr">QR Code</option>
                                </select>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="autoGenerateBarcode" checked>
                                <label class="form-check-label" for="autoGenerateBarcode">Auto-generate Barcodes for New Products</label>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Barcode Prefix</label>
                                <input type="text" class="form-control" placeholder="e.g., PNN-" value="PNN-">
                                <div class="form-text text-muted">
                                    This prefix will be added to all auto-generated barcodes.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Fiscal Year</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Fiscal Year Start</label>
                                <select class="form-select">
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="autoAnnualInventory" checked>
                                <label class="form-check-label" for="autoAnnualInventory">Schedule Annual Inventory Count</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Date & Time Format</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Date Format</label>
                                <select class="form-select">
                                    <option value="mm/dd/yyyy">MM/DD/YYYY</option>
                                    <option value="dd/mm/yyyy">DD/MM/YYYY</option>
                                    <option value="yyyy-mm-dd">YYYY-MM-DD</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Time Format</label>
                                <select class="form-select">
                                    <option value="12">12-hour (AM/PM)</option>
                                    <option value="24">24-hour</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Stock Levels Settings -->
        <div class="tab-pane fade" id="stock" role="tabpanel" aria-labelledby="stock-tab">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Stock Level Thresholds</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                These settings apply to all products by default. You can override them for individual products.
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Low Stock Threshold (%)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" value="20">
                                    <span class="input-group-text">%</span>
                                </div>
                                <div class="form-text text-muted">
                                    Products will be marked as "Low Stock" when they reach this percentage of their optimal stock level.
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Critical Stock Threshold (%)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" value="10">
                                    <span class="input-group-text">%</span>
                                </div>
                                <div class="form-text text-muted">
                                    Products will be marked as "Critical Stock" when they reach this percentage of their optimal stock level.
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Overstock Threshold (%)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" value="150">
                                    <span class="input-group-text">%</span>
                                </div>
                                <div class="form-text text-muted">
                                    Products will be marked as "Overstocked" when they exceed this percentage of their optimal stock level.
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Stock Adjustment Rules</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Stock Adjustment Approval</label>
                                <select class="form-select">
                                    <option value="none">No approval required</option>
                                    <option value="manager" selected>Manager approval required</option>
                                    <option value="admin">Admin approval required</option>
                                </select>
                                <div class="form-text text-muted">
                                    Determines who needs to approve manual stock adjustments.
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Adjustment Reason Required</label>
                                <select class="form-select">
                                    <option value="always" selected>Always required</option>
                                    <option value="decrease">Required for decreases only</option>
                                    <option value="never">Never required</option>
                                </select>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="trackAdjustmentHistory" checked>
                                <label class="form-check-label" for="trackAdjustmentHistory">Track Adjustment History</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Reorder Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="autoReorderEnabled" checked>
                                <label class="form-check-label" for="autoReorderEnabled">Enable Automatic Reorder Suggestions</label>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Reorder Point Calculation</label>
                                <select class="form-select">
                                    <option value="fixed">Fixed Threshold</option>
                                    <option value="leadtime" selected>Based on Lead Time</option>
                                    <option value="sales">Based on Sales Velocity</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Default Lead Time (days)</label>
                                <input type="number" class="form-control" value="7">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Safety Stock (days)</label>
                                <input type="number" class="form-control" value="3">
                                <div class="form-text text-muted">
                                    Additional days of stock to maintain as a buffer.
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Stock Status Colors</h5>
                            <button class="btn btn-sm btn-outline-secondary">Reset to Default</button>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label d-flex justify-content-between">
                                    <span>In Stock</span>
                                    <span class="badge bg-success">Current</span>
                                </label>
                                <input type="color" class="form-control form-control-color w-100" value="#198754">
                            </div>

                            
                            <div class="mb-3">
                                <label class="form-label d-flex justify-content-between">
                                    <span>Low Stock</span>
                                    <span class="badge bg-warning text-dark">Current</span>
                                </label>
                                <input type="color" class="form-control form-control-color w-100" value="#ffc107">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label d-flex justify-content-between">
                                    <span>Out of Stock</span>
                                    <span class="badge bg-danger">Current</span>
                                </label>
                                <input type="color" class="form-control form-control-color w-100" value="#dc3545">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label d-flex justify-content-between">
                                    <span>Overstocked</span>
                                    <span class="badge bg-info">Current</span>
                                </label>
                                <input type="color" class="form-control form-control-color w-100" value="#0dcaf0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Locations Settings -->
        <div class="tab-pane fade" id="locations" role="tabpanel" aria-labelledby="locations-tab">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Warehouse Locations</h5>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addLocationModal">
                                <i class="fas fa-plus me-1"></i> Add Location
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Main Warehouse</td>
                                            <td>Primary</td>
                                            <td>123 Main St, Anytown, USA</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary me-1">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>East Coast Fulfillment</td>
                                            <td>Secondary</td>
                                            <td>456 Commerce Dr, Eastville, USA</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary me-1">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>West Storage</td>
                                            <td>Storage</td>
                                            <td>789 Warehouse Blvd, Westcity, USA</td>
                                            <td><span class="badge bg-secondary">Inactive</span></td>
                                            <td>
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
                    
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Location Structure</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Location Naming Convention</label>
                                <select class="form-select">
                                    <option value="aisle-shelf-bin">Aisle-Shelf-Bin</option>
                                    <option value="zone-row-bay-level">Zone-Row-Bay-Level</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Location Code Format</label>
                                <input type="text" class="form-control" value="[A-Z][0-9][0-9]">
                                <div class="form-text text-muted">
                                    Example: A01, B12, etc.
                                </div>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="enforceLocationCodes" checked>
                                <label class="form-check-label" for="enforceLocationCodes">Enforce Location Codes</label>
                                <div class="form-text text-muted">
                                    If enabled, all inventory must be assigned to a valid location.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Transfer Settings</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Default Transfer Method</label>
                                <select class="form-select">
                                    <option value="immediate">Immediate Transfer</option>
                                    <option value="scheduled">Scheduled Transfer</option>
                                    <option value="two-step" selected>Two-Step (Ship & Receive)</option>
                                </select>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="requireTransferApproval">
                                <label class="form-check-label" for="requireTransferApproval">Require Transfer Approval</label>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="autoReceiveTransfers">
                                <label class="form-check-label" for="autoReceiveTransfers">Auto-receive Transfers After</label>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Auto-receive After (days)</label>
                                <input type="number" class="form-control" value="3">
                            </div>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Default Location</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Default Receiving Location</label>
                                <select class="form-select">
                                    <option value="main">Main Warehouse</option>
                                    <option value="east">East Coast Fulfillment</option>
                                    <option value="west">West Storage</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Default Shipping Location</label>
                                <select class="form-select">
                                    <option value="main">Main Warehouse</option>
                                    <option value="east">East Coast Fulfillment</option>
                                    <option value="west">West Storage</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Notifications Settings -->
        <div class="tab-pane fade" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Stock Alert Notifications</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="lowStockAlerts" checked>
                                <label class="form-check-label" for="lowStockAlerts">Low Stock Alerts</label>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="outOfStockAlerts" checked>
                                <label class="form-check-label" for="outOfStockAlerts">Out of Stock Alerts</label>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="overstockAlerts">
                                <label class="form-check-label" for="overstockAlerts">Overstock Alerts</label>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="expirationAlerts" checked>
                                <label class="form-check-label" for="expirationAlerts">Expiration Date Alerts</label>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Expiration Alert Lead Time (days)</label>
                                <input type="number" class="form-control" value="30">
                                <div class="form-text text-muted">
                                    Number of days before expiration to send alerts.
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Notification Recipients</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Primary Contact Email</label>
                                <input type="email" class="form-control" value="inventory@pnnshop.com">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Additional Recipients</label>
                                <select class="form-select" multiple size="4">
                                    <option value="1" selected>John Doe (Inventory Manager)</option>
                                    <option value="2" selected>Jane Smith (Purchasing)</option>
                                    <option value="3">Mike Johnson (Warehouse)</option>
                                    <option value="4">Sarah Williams (Operations)</option>
                                </select>
                                <div class="form-text text-muted">
                                    Hold Ctrl/Cmd to select multiple recipients.
                                </div>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="notifySuppliers">
                                <label class="form-check-label" for="notifySuppliers">Automatically Notify Suppliers for Low Stock</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Notification Methods</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                <label class="form-check-label" for="emailNotifications">Email Notifications</label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="smsNotifications">
                                <label class="form-check-label" for="smsNotifications">SMS Notifications</label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="inAppNotifications" checked>
                                <label class="form-check-label" for="inAppNotifications">In-App Notifications</label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="pushNotifications" checked>
                                <label class="form-check-label" for="pushNotifications">Push Notifications</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Notification Schedule</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Notification Frequency</label>
                                <select class="form-select">
                                    <option value="realtime">Real-time</option>
                                    <option value="hourly">Hourly Digest</option>
                                    <option value="daily" selected>Daily Digest</option>
                                    <option value="weekly">Weekly Digest</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Daily Digest Time</label>
                                <input type="time" class="form-control" value="08:00">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Weekly Digest Day</label>
                                <select class="form-select">
                                    <option value="1">Monday</option>
                                    <option value="2">Tuesday</option>
                                    <option value="3">Wednesday</option>
                                    <option value="4">Thursday</option>
                                    <option value="5" selected>Friday</option>
                                    <option value="6">Saturday</option>
                                    <option value="0">Sunday</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Advanced Settings -->
        <div class="tab-pane fade" id="advanced" role="tabpanel" aria-labelledby="advanced-tab">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Batch & Lot Tracking</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="enableBatchTracking" checked>
                                <label class="form-check-label" for="enableBatchTracking">Enable Batch/Lot Tracking</label>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Batch Number Format</label>
                                <input type="text" class="form-control" value="BAT-{YYYY}{MM}-{####}">
                                <div class="form-text text-muted">
                                    Use {YYYY} for year, {MM} for month, {DD} for day, {####} for sequential number.
                                </div>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="enforceExpiryDates" checked>
                                <label class="form-check-label" for="enforceExpiryDates">Enforce Expiry Dates for Batches</label>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Default Batch Selection Method</label>
                                <select class="form-select">
                                    <option value="fifo" selected>FIFO (First Expiry, First Out)</option>
                                    <option value="fefo">FEFO (First Expiry, First Out)</option>
                                    <option value="manual">Manual Selection</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Inventory Counting</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Inventory Count Frequency</label>
                                <select class="form-select">
                                    <option value="monthly">Monthly</option>
                                    <option value="quarterly" selected>Quarterly</option>
                                    <option value="biannual">Bi-annual</option>
                                    <option value="annual">Annual</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Count Method</label>
                                <select class="form-select">
                                    <option value="full">Full Inventory Count</option>
                                    <option value="cycle" selected>Cycle Counting</option>
                                    <option value="abc">ABC Analysis Based</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Cycle Count Groups</label>
                                <input type="number" class="form-control" value="4">
                                <div class="form-text text-muted">
                                    Number of groups to divide inventory into for cycle counting.
                                </div>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="freezeInventoryDuringCount" checked>
                                <label class="form-check-label" for="freezeInventoryDuringCount">Freeze Inventory During Count</label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">Data Management</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Stock History Retention</label>
                                <select class="form-select">
                                    <option value="6">6 months</option>
                                    <option value="12" selected>1 year</option>
                                    <option value="24">2 years</option>
                                    <option value="36">3 years</option>
                                    <option value="0">Indefinitely</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Auto-archive Inactive Products</label>
                                <select class="form-select">
                                    <option value="0">Never</option>
                                    <option value="30">After 30 days</option>
                                    <option value="90" selected>After 90 days</option>
                                    <option value="180">After 180 days</option>
                                    <option value="365">After 1 year</option>
                                </select>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="enableDataExport" checked>
                                <label class="form-check-label" for="enableDataExport">Enable Scheduled Data Exports</label>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Export Format</label>
                                <select class="form-select">
                                    <option value="csv" selected>CSV</option>
                                    <option value="excel">Excel</option>
                                    <option value="json">JSON</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">System Integration</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="enableApiAccess" checked>
                                <label class="form-check-label" for="enableApiAccess">Enable API Access</label>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="syncWithEcommerce" checked>
                                <label class="form-check-label" for="syncWithEcommerce">Sync with E-commerce Platform</label>
                            </div>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="syncWithAccounting">
                                <label class="form-check-label" for="syncWithAccounting">Sync with Accounting Software</label>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Sync Frequency</label>
                                <select class="form-select">
                                    <option value="realtime">Real-time</option>
                                    <option value="hourly" selected>Hourly</option>
                                    <option value="daily">Daily</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Save Settings Button (Fixed at Bottom) -->
    <div class="position-sticky bottom-0 bg-white py-3 border-top mt-4" style="z-index: 100;">
        <div class="d-flex justify-content-end">
            <button class="btn btn-secondary me-2">Cancel</button>
            <button class="btn btn-primary" id="saveSettingsBottom">
                <i class="fas fa-save me-2"></i>Save Changes
            </button>
        </div>
    </div>
</div>

<!-- Add Location Modal -->
<div class="modal fade" id="addLocationModal" tabindex="-1" aria-labelledby="addLocationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLocationModalLabel">Add New Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Location Name</label>
                    <input type="text" class="form-control" placeholder="e.g., South Warehouse">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Location Type</label>
                    <select class="form-select">
                        <option value="primary">Primary</option>
                        <option value="secondary">Secondary</option>
                        <option value="storage">Storage</option>
                        <option value="retail">Retail</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea class="form-control" rows="3" placeholder="Full address"></textarea>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Contact Person</label>
                    <input type="text" class="form-control" placeholder="Name of contact person">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Contact Phone</label>
                    <input type="tel" class="form-control" placeholder="Phone number">
                </div>
                
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="locationActive" checked>
                    <label class="form-check-label" for="locationActive">Active</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Add Location</button>
            </div>
        </div>
    </div>
</div>
<script>
    // Make sure Font Awesome is loaded
    if (typeof FontAwesome === 'undefined') {
        var link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css';
        document.head.appendChild(link);
    }
    
    // Save settings functionality
    document.getElementById('saveSettings').addEventListener('click', function() {
        // Show success message
        alert('Settings saved successfully!');
    });
    
    document.getElementById('saveSettingsBottom').addEventListener('click', function() {
        // Show success message
        alert('Settings saved successfully!');
    });
</script>