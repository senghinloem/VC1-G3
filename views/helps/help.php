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
                <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            How do I add a new product to the inventory?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Go to "Product Management" from the sidebar, click "Create Product," and fill in the required details such as name, price, and stock quantity. You can also add product images, descriptions, and set categories to organize your inventory effectively.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            How can I update stock levels?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Navigate to "Stock Management," find the product you want to update, and adjust the stock quantity using the provided form. You can also set up low stock alerts to be notified when inventory reaches a certain threshold.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            What should I do if I encounter an error?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Try refreshing the page. If the issue persists, contact our support team using the information below. It's helpful to include screenshots and details about what you were doing when the error occurred.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            How do I process customer returns?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Go to "Orders" section, find the order in question, and click on "Process Return." Follow the guided steps to approve the return, issue a refund if necessary, and update inventory once the item is received back.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item border-0 mb-3 shadow-sm rounded">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button collapsed rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            How can I generate sales reports?
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Navigate to the "Reports" section from the main dashboard. You can generate various reports including daily/monthly sales, product performance, and customer analytics. Reports can be exported in CSV, PDF, or Excel formats.
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
                    <a href="mailto:support@pnnshop.com" class="btn btn-primary">support@pnnshop.com</a>
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
                    <a href="tel:+15551234567" class="btn btn-primary">+1 (555) 123-4567</a>
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