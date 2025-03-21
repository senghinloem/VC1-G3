<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Help & Support</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .help-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        .section-title {
            font-weight: bold;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
            display: inline-block;
        }
        .faq-item {
            margin-bottom: 15px;
        }
        .faq-item h6 {
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container mt-4 mb-4">
    <div class="help-container p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">❓ Help & Support</h3>
            <a href="#" class="btn btn-outline-primary">⬅ Back to Dashboard</a>
        </div>

        <!-- FAQs Section -->
        <h5 class="section-title">Frequently Asked Questions (FAQs)</h5>
        <div class="accordion mt-3" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                        How do I add a new product to the inventory?
                    </button>
                </h2>
                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Go to "Product Management" from the sidebar, click "Create Product," and fill in the required details such as name, price, and stock quantity.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                        How can I update stock levels?
                    </button>
                </h2>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Navigate to "Stock Management," find the product you want to update, and adjust the stock quantity using the provided form.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                        What should I do if I encounter an error?
                    </button>
                </h2>
                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Try refreshing the page. If the issue persists, contact our support team using the information below.
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Support Section -->
        <h5 class="section-title mt-4">Contact Support</h5>
        <p><strong>Email:</strong> <a href="mailto:support@pnnshop.com">support@pnnshop.com</a></p>
        <p><strong>Phone:</strong> +1 (555) 123-4567</p>
        <p><strong>Hours:</strong> Monday - Friday, 9:00 AM - 5:00 PM (EST)</p>

        <!-- Additional Resources -->
        <h5 class="section-title mt-4">Additional Resources</h5>
        <ul class="list-unstyled">
            <li>📄 <a href="#">User Guide (PDF)</a></li>
            <li>🎥 <a href="#">Video Tutorials</a></li>
            <li>💬 <a href="#">Community Forum</a></li>
        </ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
