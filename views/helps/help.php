<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Help & Support - PNN Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="views/assets/css/help.css"> -->

</head>

<body>

    <!-- Header with Search -->
    <!-- Help Content - This will fit inside your dashboard's main content area -->
    <div class="container-fluid px-4 py-3">
        <!-- Page Title -->
        <h1 class="mb-4">How can we help?</h1>

        <!-- Search Bar -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search for help..." onkeyup="searchFAQs()">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Help Categories -->
        <div class="row mb-5">
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0 rounded-3 hover-lift">
                    <div class="card-body p-4">
                        <div class="text-center mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 d-inline-block">
                                <i class="fas fa-shopping-cart text-primary fa-2x"></i>
                            </div>
                        </div>
                        <h4 class="card-title text-center">Orders & Shipping</h4>
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
                        <h4 class="card-title text-center">Products & Inventory</h4>
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
                        <h4 class="card-title text-center">Account Settings</h4>
                        <p class="card-text text-muted text-center">Manage your account and preferences</p>
                        <div class="text-center mt-3">
                            <a href="#" class="btn btn-outline-primary">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQs Section -->
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="mb-4">Frequently Asked Questions</h2>
            </div>

            <div class="col-12">
                <div class="accordion" id="faqAccordion">

                    <!-- Dashboard Management -->
                    <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Dashboard Page Guide ?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                View key metrics like total products, item count, overall cost, and low stock alerts at the top.
                                Check stock levels with the bar chart (low stock in red, high stock in blue) and unit distribution in the pie chart show with specifict unit and precentage.
                                Use the "Filter Product" section to search products by name and price or filter by unit, and sort the table by clicking column headers like Product ID or Price.
                            </div>
                        </div>
                    </div>

                    <!-- Product Management -->
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


                    <!-- Stock Management -->
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

                    <!-- Suppliers Management -->
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

                    <!-- Productlist Management -->
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



                    <!-- User Management -->
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

                    <!-- Setiting Page -->
                    <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                        <h2 class="accordion-header" id="headingSeven">
                            <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                How To Use Setting Page?
                            </button>
                        </h2>
                        <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Not yet
                            </div>
                        </div>
                    </div>

                    <!-- Settings -->
                    <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                        <h2 class="accordion-header" id="headingEight">
                            <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                How To Use Help Page?
                            </button>
                        </h2>
                        <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Not yet
                            </div>
                        </div>
                    </div>
                </div>
                <div id="noResultsMessage" class="alert alert-info mt-3 d-none">
                    No FAQs match your search. Try different keywords or contact our support team for assistance.
                </div>
            </div>
        </div>

        <!-- Contact Support Section -->
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="mb-4">Contact Support</h2>
            </div>

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
                        <a href="#" class="btn btn-primary">dinleader@gmail.com</a>
                    </div>
                </div>
            </div>

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
                        <a href="tel:+15551234567" class="btn btn-primary">+855 69505726</a>
                    </div>
                </div>
            </div>

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
                        <p class="mb-0">Monday - Friday<br>9:00 AM - 5:00 PM (EST)</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resources Section -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="mb-4">Additional Resources</h2>
            </div>

            <div class="col-md-6 mb-3">
                <a href="#" class="text-decoration-none">
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

    <style>
        /* Custom styles that will work within your dashboard */
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .accordion-button:not(.collapsed) {
            background-color: rgba(var(--bs-primary-rgb), 0.1);
            color: var(--bs-primary);
        }

        .accordion-button:focus {
            box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
        }
    </style>

    <script>
        // Make sure Font Awesome is loaded
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
</body>

</html>