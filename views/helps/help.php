<?php
// Check if an email has been clicked and submitted via GET
$selectedEmail = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Help & Support - PNN Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">   
    <link rel="stylesheet" href="../../views/assets/css/help.css">

</head>

<body>
    <div class="container-fluid px-4 py-3">
        <h1 class="mb-4">How can we help?</h1>

    
        <div class="container my-5">
            <div id="cardCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                <div class="carousel-inner">
                    <!-- First Set of Cards -->
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm border-0 rounded-3 hover-lift">
                                    <div class="card-body p-4">
                                        <div class="text-center mb-3">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-block">
                                                <i class="fas fa-shopping-cart text-primary fa-2x"></i>
                                            </div>
                                        </div>
                                        <h4 class="card-title text-center">Stock Management</h4>
                                        <p class="card-text text-muted text-center">Track orders, shipping info, and returns</p>
                                        <div class="text-center mt-3">
                                            <a href="#" class="btn btn-outline-primary">Learn More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm border-0 rounded-3 hover-lift">
                                    <div class="card-body p-4">
                                        <div class="text-center mb-3">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-block">
                                                <i class="fas fa-box-open text-primary fa-2x"></i>
                                            </div>
                                        </div>
                                        <h4 class="card-title text-center">Products Management</h4>
                                        <p class="card-text text-muted text-center">Manage products and stock levels</p>
                                        <div class="text-center mt-3">
                                            <a href="#" class="btn btn-outline-primary">Learn More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm border-0 rounded-3 hover-lift">
                                    <div class="card-body p-4">
                                        <div class="text-center mb-3">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-block">
                                                <i class="fas fa-user-cog text-primary fa-2x"></i>
                                            </div>
                                        </div>
                                        <h4 class="card-title text-center">Settings</h4>
                                        <p class="card-text text-muted text-center">Manage your system and preferences</p>
                                        <div class="text-center mt-3">
                                            <a href="#" class="btn btn-outline-primary">Learn More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Second Set of Cards -->
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm border-0 rounded-3 hover-lift">
                                    <div class="card-body p-4">
                                        <div class="text-center mb-3">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-block">
                                                <i class="fas fa-users text-primary fa-2x"></i>
                                            </div>
                                        </div>
                                        <h4 class="card-title text-center">User Management</h4>
                                        <p class="card-text text-muted text-center">Manage user accounts and permissions</p>
                                        <div class="text-center mt-3">
                                            <a href="#" class="btn btn-outline-primary">Learn More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm border-0 rounded-3 hover-lift">
                                    <div class="card-body p-4">
                                        <div class="text-center mb-3">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-block">
                                                <i class="fas fa-truck text-primary fa-2x"></i>
                                            </div>
                                        </div>
                                        <h4 class="card-title text-center">Supplier Management</h4>
                                        <p class="card-text text-muted text-center">Track suppliers and their details</p>
                                        <div class="text-center mt-3">
                                            <a href="#" class="btn btn-outline-primary">Learn More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm border-0 rounded-3 hover-lift">
                                    <div class="card-body p-4">
                                        <div class="text-center mb-3">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-block">
                                                <i class="fas fa-list text-primary fa-2x"></i>
                                            </div>
                                        </div>
                                        <h4 class="card-title text-center">Product List</h4>
                                        <p class="card-text text-muted text-center">View and edit product catalog</p>
                                        <div class="text-center mt-3">
                                            <a href="#" class="btn btn-outline-primary">Learn More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Third Set of Cards -->
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm border-0 rounded-3 hover-lift">
                                    <div class="card-body p-4">
                                        <div class="text-center mb-3">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-block">
                                                <i class="fas fa-bell text-primary fa-2x"></i>
                                            </div>
                                        </div>
                                        <h4 class="card-title text-center">Notification</h4>
                                        <p class="card-text text-muted text-center">Stay updated with alerts</p>
                                        <div class="text-center mt-3">
                                            <a href="#" class="btn btn-outline-primary">Learn More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm border-0 rounded-3 hover-lift">
                                    <div class="card-body p-4">
                                        <div class="text-center mb-3">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-block">
                                                <i class="fas fa-question-circle text-primary fa-2x"></i>
                                            </div>
                                        </div>
                                        <h4 class="card-title text-center">Help Page</h4>
                                        <p class="card-text text-muted text-center">Get support and documentation</p>
                                        <div class="text-center mt-3">
                                            <a href="#" class="btn btn-outline-primary">Learn More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm border-0 rounded-3 hover-lift">
                                    <div class="card-body p-4">
                                        <div class="text-center mb-3">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-block">
                                                <i class="fas fa-chart-bar text-primary fa-2x"></i>
                                            </div>
                                        </div>
                                        <h4 class="card-title text-center">Report Page</h4>
                                        <p class="card-text text-muted text-center">Generate and view reports</p>
                                        <div class="text-center mt-3">
                                            <a href="#" class="btn btn-outline-primary">Learn More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carousel Indicators -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#cardCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#cardCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#cardCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#cardCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#cardCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
               
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-12">
                <h2 class="mb-4">Frequently Asked Questions</h2>
            </div>

            <div class="col-12">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Dashboard Page Guide ?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                View key metrics like total products, item count, overall cost, and low stock alerts at the top.
                                Check stock levels with the bar chart (low stock in red, high stock in blue) and unit distribution in the pie chart show with specific unit and percentage.
                                Use the "Filter Product" section to search products by name and price or filter by unit, and sort the table by clicking column headers like Product ID or Price.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                How To Use Product Management Page ?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Go to "Product Management" from the sidebar, click "Add Product if you have excel file you can import excel file also"
                                and fill in the required details such as name, price, and stock quantity. You can also add product images, descriptions,
                                and set categories to organize your inventory effectively. If you want to add product by excel file in your excel table
                                must like table in this system.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                How To User Stock Management Page ?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Navigate to "Stock Management," find the product you want to update, and adjust the stock quantity using the provided form.
                                You can also set up low stock alerts to be notified when inventory reaches a certain threshold.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                How To Use Suppliers Management Page Guide ?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                View and manage supplier details in a table showing supplier name, email, phone, address, and creation date. Use the top-right search bar to find suppliers by name or other details.
                                Add new suppliers by clicking the "Create Supplier" button. Sort the table by clicking column headers like Supplier Name or Created At. Use the Actions column to edit or delete suppliers as needed.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                How To Use Product List Page?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                View products in a table with Product ID, Name, Price, Unit, Stock ID, and Stock Name. Search products using the top-right search bar. Sort by clicking column headers like Product Name or Price.
                                Edit or delete products via the Actions column using the Edit (green) or Delete (red) buttons.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                        <h2 class="accordion-header" id="headingSix">
                            <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                How To Use User Management Page ?
                            </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                View a quick summary of user activity, including total users, online/offline counts, and online rate percentage. Use the sidebar menu on the left to navigate to sections like
                                Dashboard or Settings. See a table listing all users with their profile picture, first name, last name, email, and online/offline status. Filter users on button "Sercher User.." by typing a name or
                                email in the top-right search bar, and sort the table by clicking column headers like First Name or Email. Check user details and status (edit/delete options may be available
                                based on permissions). Sign out securely using the red Logout button in the sidebar, or click Help for more support.
                            </div>
                        </div>
                    </div>

                    <!-- Settings Guide Accordion Item -->
                    <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                        <h2 class="accordion-header" id="headingSeven">
                            <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                How To Use Setting Page?
                            </button>
                        </h2>
                        <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <!-- Inner Tabs for Settings Guide -->
                                <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">
                                            <span class="icon">⚙️</span> General
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="stock-levels-tab" data-bs-toggle="tab" data-bs-target="#stock-levels" type="button" role="tab" aria-controls="stock-levels" aria-selected="false">
                                            <span class="icon">📊</span> Stock Levels
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="locations-tab" data-bs-toggle="tab" data-bs-target="#locations" type="button" role="tab" aria-controls="locations" aria-selected="false">
                                            <span class="icon">🏠</span> Locations
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" type="button" role="tab" aria-controls="notifications" aria-selected="false">
                                            <span class="icon">🔔</span> Notifications
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="advanced-tab" data-bs-toggle="tab" data-bs-target="#advanced" type="button" role="tab" aria-controls="advanced" aria-selected="false">
                                            <span class="icon">⚡</span> Advanced
                                        </button>
                                    </li>
                                </ul>

                                <!-- Inner Tab Content -->
                                <div class="tab-content" id="settingsTabsContent">
                                    <!-- General Tab -->
                                    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                        <h4>General Settings (Basic Rules)</h4>
                                        <p>This tab sets the basic rules for your inventory.</p>
                                        <ul>
                                            <li><strong>Basic Rules:</strong> Start with how you count and track items.</li>
                                            <li>Pick "FIFO (First In, First Out)" for counting sold items (uses oldest stock first).</li>
                                            <li>Choose "Piece" to measure items (one item at a time).</li>
                                            <li>Turn "Allow Negative Stock" to "Off" (gray) so you can’t sell at zero stock.</li>
                                            <li>Turn "Update Stock on Sales" to "On" (blue) to lower stock automatically when you sell.</li>
                                            <li><strong>Business Year:</strong> Set your year for reports.</li>
                                            <li>Pick "January" as the start month.</li>
                                            <li>Turn "Schedule Annual Inventory Count" to "On" to count stock yearly.</li>
                                            <li>Set date format to "MM/DD/YYYY" for reports.</li>
                                        </ul>
                                        <p>Click "Save Changes" to keep your settings, or "Cancel" to skip.</p>
                                    </div>

                                    <!-- Stock Levels Tab -->
                                    <div class="tab-pane fade" id="stock-levels" role="tabpanel" aria-labelledby="stock-levels-tab">
                                        <h4>Stock Levels (Track Stock)</h4>
                                        <p>This tab sets when to warn you about low or high stock and helps with reordering.</p>
                                        <ul>
                                            <li><strong>Stock Warnings:</strong> Set when to get alerts for low or high stock.</li>
                                            <li>Set "Low Stock Warning" to 20%. Example: If normal stock is 100, it warns at 20 items.</li>
                                            <li>Set "Critical Stock Warning" to 10%. Example: Warns at 10 items if normal is 100.</li>
                                            <li>Set "Overstock Warning" to 150%. Example: Warns at 150 items if normal is 100.</li>
                                            <li><strong>Reorder Help:</strong> Suggest when to order more stock.</li>
                                            <li>Turn "Enable Automatic Reorder Suggestions" to "On."</li>
                                            <li>Set "Default Lead Time" to 7 days (time to get new stock).</li>
                                            <li>Set "Safety Stock" to 3 days (extra stock to avoid running out).</li>
                                        </ul>
                                        <p>Click "Save Changes" to keep your settings, or "Cancel" to skip.</p>
                                    </div>

                                    <!-- Locations Tab -->
                                    <div class="tab-pane fade" id="locations" role="tabpanel" aria-labelledby="locations-tab">
                                        <h4>Locations (Manage Where You Store Stock)</h4>
                                        <p>This tab manages where you store your stock.</p>
                                        <ul>
                                            <li><strong>Add Warehouses:</strong> Add places where you keep stock.</li>
                                            <li>Click "+ Add Location." Add name, type (like Primary), address, and status (Active or Inactive).</li>
                                            <li>To change or remove, click the pencil to edit or trash can to delete.</li>
                                            <li><strong>Name Storage Spots:</strong> Set how to name spots in your warehouse.</li>
                                            <li>Pick "Aisle-Shelf-Bin." Example: A spot might be "A1-S2-B3."</li>
                                            <li><strong>Move Stock:</strong> Set rules for moving stock between places.</li>
                                            <li>Pick "Two-Step (Ship & Receive)" for transfers.</li>
                                            <li>Turn "Require Transfer Approval" to "Off" (gray) if you don’t want approvals.</li>
                                            <li>Set "Auto-receive After" to 3 days (auto-receives stock after 3 days).</li>
                                        </ul>
                                        <p>Click "Save Changes" to keep your settings, or "Cancel" to skip.</p>
                                    </div>

                                    <!-- Notifications Tab -->
                                    <div class="tab-pane fade" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
                                        <h4>Notifications (Get Alerts)</h4>
                                        <p>This tab sets how and when you get alerts about your stock.</p>
                                        <ul>
                                            <li><strong>Stock Alerts:</strong></li>
                                            <li>Turn "Low Stock Alerts" to "On" for low stock warnings.</li>
                                            <li>Turn "Out of Stock Alerts" to "On" for zero stock warnings.</li>
                                            <li>Turn "Overstock Alerts" to "On" for too much stock warnings.</li>
                                            <li>Turn "Expiration Date Alerts" to "On" for items near expiry.</li>
                                            <li>Set "Expiration Lead Time" to 30 days (warns 30 days before expiry).</li>
                                            <li><strong>How to Get Alerts:</strong> Choose how to get warnings.</li>
                                            <li>Check "Email," "SMS," "In-App," and "Push Notifications" to get alerts everywhere.</li>
                                            <li>Pick "Daily Digest" to get one summary email per day.</li>
                                        </ul>
                                        <p>Make sure at least one alert method (like Email) is on to get warnings. Click "Save Changes" to keep your settings, or "Cancel" to skip.</p>
                                    </div>

                                    <!-- Advanced Tab -->
                                    <div class="tab-pane fade" id="advanced" role="tabpanel" aria-labelledby="advanced-tab">
                                        <h4>Advanced (Track Batches and Data)</h4>
                                        <p>This tab has extra settings for tracking batches and managing data.</p>
                                        <ul>
                                            <li><strong>Batch Tracking:</strong> Track items by batch numbers (like for expiry dates).</li>
                                            <li>Turn "Enable Batch/Lot Tracking" to "On."</li>
                                            <li>Set "Batch Number Format" to "BAT-[YYYY][MM]-[#####]." Example: "BAT-202504-00001."</li>
                                            <li>Turn "Enforce Expiry Dates for Batches" to "On" to require expiry dates.</li>
                                            <li>Pick "FIFO (First Expiry, First Out)" to use batches expiring first.</li>
                                            <li><strong>Data Saving:</strong> Decide how long to keep data.</li>
                                            <li>Set "Stock History Retention" to "1 Year" to keep data for 1 year.</li>
                                            <li>Set "Auto-archive Inactive Products" to "After 90 days" to hide old products.</li>
                                            <li>Turn "Enable Scheduled Data Exports" to "On" to export data automatically.</li>
                                            <li>Pick "CSV" as the export format.</li>
                                        </ul>
                                        <p>Click "Save Changes" to keep your settings, or "Cancel" to skip.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="noResultsMessage" class="alert alert-info mt-3 d-none">
                    No FAQs match your search. Try different keywords or contact our support team for assistance.
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-12">
                <h2 class="mb-4">Contact Support</h2>
            </div>

            <!-- Email Card with Carousel (No Auto Move) -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0 rounded-3 hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-block">
                                <i class="fas fa-envelope text-primary fa-2x"></i>
                            </div>
                        </div>
                        <h4 class="card-title">Email Support</h4>
                        <p class="card-text text-muted mb-3">Get help via email</p>
                        <div id="emailCarousel" class="carousel slide">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <a href="mailto:dinleader@gmail.com" class="btn btn-primary">dinleader@gmail.com</a>
                                </div>
                                <div class="carousel-item">
                                    <a href="mailto:support1@example.com" class="btn btn-primary">senghin@gmail.com</a>
                                </div>
                                <div class="carousel-item">
                                    <a href="mailto:support2@example.com" class="btn btn-primary">bunny@gmail.com</a>
                                </div>
                                <div class="carousel-item">
                                    <a href="mailto:support3@example.com" class="btn btn-primary">ya@gmail.com</a>
                                </div>
                                <div class="carousel-item">
                                    <a href="mailto:support4@example.com" class="btn btn-primary">sreynich@gmail.com</a>
                                </div>
                            </div>
                            <button class="carousel-control-prev custom-carousel-control" type="button" data-bs-target="#emailCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon custom-blue-arrow" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next custom-carousel-control" type="button" data-bs-target="#emailCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon custom-blue-arrow" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Phone Card with Carousel (No Auto Move) -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0 rounded-3 hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-block">
                                <i class="fas fa-phone-alt text-primary fa-2x"></i>
                            </div>
                        </div>
                        <h4 class="card-title">Phone Support</h4>
                        <p class="card-text text-muted mb-3">Talk to our team directly</p>
                        <div id="phoneCarousel" class="carousel slide">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <a href="tel:+85569505726" class="btn btn-primary">+855 69505726</a>
                                </div>
                                <div class="carousel-item">
                                    <a href="tel:+85512345678" class="btn btn-primary">+855 12345678</a>
                                </div>
                                <div class="carousel-item">
                                    <a href="tel:+85587654321" class="btn btn-primary">+855 87654321</a>
                                </div>
                                <div class="carousel-item">
                                    <a href="tel:+85598765432" class="btn btn-primary">+855 98765432</a>
                                </div>
                            </div>
                            <button class="carousel-control-prev custom-carousel-control" type="button" data-bs-target="#phoneCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon custom-blue-arrow" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next custom-carousel-control" type="button" data-bs-target="#phoneCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon custom-blue-arrow" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Support Hours Card with Carousel (No Auto Move) -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0 rounded-3 hover-lift">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-block">
                                <i class="fas fa-clock text-primary fa-2x"></i>
                            </div>
                        </div>
                        <h4 class="card-title">Support Hours</h4>
                        <p class="card-text text-muted mb-3">When we're available</p>
                        <div id="hoursCarousel" class="carousel slide">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <p class="mb-0">Monday - Friday<br>5:00 pM - 9:00 PM (EST)</p>
                                </div>
                                <div class="carousel-item">
                                    <p class="mb-0">Saturday - Sunday<br>7:00 AM - 6:00 PM (EST)</p>
                                </div>
                            </div>
                            <button class="carousel-control-prev custom-carousel-control" type="button" data-bs-target="#hoursCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon custom-blue-arrow" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next custom-carousel-control" type="button" data-bs-target="#hoursCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon custom-blue-arrow" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mb-4">
            <div class="col-12">
                <h2 class="mb-4">Additional Resources</h2>
            </div>

            <div class="col-md-6 mb-3">
                <a href="../views/helps/user-guide.pdf" target="_blank" class="text-decoration-none">
                    <div class="card border-0 shadow-sm rounded-3 hover-lift">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                                <i class="fas fa-file-pdf text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">User Guide (PDF)</h5>
                                <p class="mb-0 text-muted small">Complete documentation for PNN Shop</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 mb-3">
                <a href="#" class="text-decoration-none">
                    <div class="card border-0 shadow-sm rounded-3 hover-lift">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                                <i class="fas fa-video text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Video Tutorials</h5>
                                <p class="mb-0 text-muted small">Step-by-step visual guides</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 mb-3">
                <a href="#" class="text-decoration-none">
                    <div class="card border-0 shadow-sm rounded-3 hover-lift">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                                <i class="fas fa-comments text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Community Forum</h5>
                                <p class="mb-0 text-muted small">Connect with other PNN Shop users</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 mb-3">
                <a href="#" class="text-decoration-none">
                    <div class="card border-0 shadow-sm rounded-3 hover-lift">
                        <div class="card-body p-3 d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                                <i class="fas fa-graduation-cap text-primary"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Training Webinars</h5>
                                <p class="mb-0 text-muted small">Live and recorded training sessions</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <script>
        if (typeof FontAwesome === 'undefined') {
            var link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css';
            document.head.appendChild(link);
        }

        function searchFAQs() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const accordionItems = document.querySelectorAll('.accordion-item');
            const noResultsMessage = document.getElementById('noResultsMessage');
            let resultsFound = false;

            accordionItems.forEach(item => {
                const question = item.querySelector('.accordion-button').textContent.toLowerCase();
                const answer = item.querySelector('.accordion-body').textContent.toLowerCase();

                if (question.includes(input) || answer.includes(input)) {
                    item.style.display = 'block';
                    resultsFound = true;
                } else {
                    item.style.display = 'none';
                }
            });

            if (resultsFound) {
                noResultsMessage.classList.add('d-none');
            } else {
                noResultsMessage.classList.remove('d-none');
            }
        }
    </script>

    <!-- Bootstrap JS (required for accordion and tabs) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>