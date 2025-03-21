<?php
session_start();
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
    <title>Product Management</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary: #1a3c34;
            --secondary: #3498db;
            --danger: #e74c3c;
            --success: #2ecc71;
            --warning: #f1c40f;
            --light: #f5f7fa;
            --gray: #7f8c8d;
            --white: #ffffff;
            --shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        body {
            background: var(--light);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 80px;
            background: var(--primary);
            padding: 2rem 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            position: fixed;
            transition: width 0.3s ease;
        }

        .sidebar:hover {
            width: 200px;
        }

        .sidebar .logo {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 2rem;
            text-align: center;
            display: block;
            width: 100%;
        }

        .sidebar .nav-item {
            position: relative;
            width: 100%;
            margin: 1rem 0;
        }

        .sidebar .nav-item a {
            color: var(--white);
            font-size: 1.2rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
        }

        .sidebar .nav-item a i {
            font-size: 1.5rem;
        }

        .sidebar .nav-item a span {
            margin-left: 1rem;
            display: none;
            font-size: 1rem;
        }

        .sidebar:hover .nav-item a span {
            display: inline;
        }

        .sidebar .nav-item a:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-item.logout a {
            color: var(--danger);
        }

        /* Main Content */
        .main-content {
            margin-left: 80px;
            padding: 2rem;
            flex: 1;
            transition: margin-left 0.3s ease;
        }

        .sidebar:hover ~ .main-content {
            margin-left: 200px;
        }

        .card-container {
            background: var(--white);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: var(--shadow);
            margin: 0 auto;
            max-width: 1600px;
            width: 100%;
        }

        /* Header Section */
        .header-section {
            margin-bottom: 2rem;
        }

        .header-section h3 {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }

        /* Statistics Cards */
        .stats-container {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--white);
            border-radius: 10px;
            padding: 1.5rem;
            flex: 1;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-card h5 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            margin: 0;
        }

        .stat-card p {
            font-size: 0.9rem;
            color: var(--gray);
            margin: 0;
            text-transform: uppercase;
        }

        .stat-card.orders-hold h5 {
            color: var(--danger);
        }

        /* Search and Add Button */
        .search-container {
            position: relative;
            max-width: 300px;
        }

        .search-container input {
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            border: 1px solid #ddd;
            box-shadow: none;
            transition: all 0.3s ease;
        }

        .search-container input:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
            outline: none;
        }

        .btn-add {
            background: var(--secondary);
            color: var(--white);
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-add:hover {
            background: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        /* Table Styling */
        .table-responsive {
            border-radius: 10px;
            overflow-x: auto;
        }

        .table {
            margin-bottom: 0;
            background: var(--white);
            width: 100%;
            table-layout: fixed;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            overflow: hidden;
        }

        thead th {
            background: var(--light);
            color: var(--primary);
            padding: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e9ecef;
        }

        tbody tr {
            transition: all 0.3s ease;
        }

        tbody tr:hover {
            background: rgba(0, 0, 0, 0.02);
            transform: translateY(-2px);
        }

        tbody td {
            padding: 1rem;
            vertical-align: middle;
            color: var(--primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Adjusted Column Widths */
        .table th:nth-child(1), .table td:nth-child(1) { width: 10%; } /* Product ID */
        .table th:nth-child(2), .table td:nth-child(2) { width: 20%; } /* Product Name */
        .table th:nth-child(3), .table td:nth-child(3) { width: 20%; } /* Stock Name */
        .table th:nth-child(4), .table td:nth-child(4) { width: 15%; } /* Price */
        .table th:nth-child(5), .table td:nth-child(5) { width: 10%; } /* Unit */
        .table th:nth-child(6), .table td:nth-child(6) { width: 10%; } /* Stock ID */
        .table th:nth-child(7), .table td:nth-child(7) { width: 10%; } /* Status */
        .table th:nth-child(8), .table td:nth-child(8) { width: 5%; }  /* Actions */

        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 0.4rem 1rem;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
        }

        .status-pending {
            background: rgba(241, 196, 15, 0.2);
            color: var(--warning);
        }

        .status-paid {
            background: rgba(46, 204, 113, 0.2);
            color: var(--success);
        }

        .status-hold {
            background: rgba(231, 76, 60, 0.2);
            color: var(--danger);
        }

        /* Action Menu Styles */
        .action-menu {
            position: relative;
            display: inline-block;
        }

        .action-toggle {
            background: transparent;
            color: var(--gray);
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .action-toggle:hover {
            background: var(--light);
            color: var(--secondary);
        }

        .action-options {
            position: absolute;
            right: 0;
            top: 100%;
            background: var(--white);
            border-radius: 10px;
            box-shadow: var(--shadow);
            min-width: 120px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
            z-index: 1000; /* Ensure it appears above other elements */
        }

        .action-menu:hover .action-options {
            opacity: 1;
            visibility: visible;
            transform: translateY(5px);
        }

        .action-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--primary);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .action-item:hover {
            background: var(--light);
            color: var(--secondary);
        }

        .action-item.danger {
            color: var(--danger);
        }

        .action-item i {
            margin-right: 0.5rem;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: var(--shadow);
        }

        .modal-header {
            background: var(--danger);
            color: var(--white);
            border-radius: 15px 15px 0 0;
        }

        .btn-custom {
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        /* Responsive Adjustments */
        @media (max-width: 1600px) {
            .card-container {
                max-width: 1400px;
            }
        }

        @media (max-width: 1400px) {
            .card-container {
                max-width: 1200px;
            }
        }

        @media (max-width: 1200px) {
            .card-container {
                max-width: 1000px;
            }

            .table th:nth-child(1), .table td:nth-child(1) { width: 8%; }
            .table th:nth-child(2), .table td:nth-child(2) { width: 18%; }
            .table th:nth-child(3), .table td:nth-child(3) { width: 18%; }
            .table th:nth-child(4), .table td:nth-child(4) { width: 14%; }
            .table th:nth-child(5), .table td:nth-child(5) { width: 12%; }
            .table th:nth-child(6), .table td:nth-child(6) { width: 12%; }
            .table th:nth-child(7), .table td:nth-child(7) { width: 12%; }
            .table th:nth-child(8), .table td:nth-child(8) { width: 6%; }
        }

        @media (max-width: 992px) {
            .main-content {
                margin-left: 0;
            }

            .sidebar {
                width: 60px;
            }

            .sidebar:hover {
                width: 60px;
            }

            .sidebar:hover .nav-item a span {
                display: none;
            }

            .card-container {
                max-width: 100%;
                padding: 1rem;
            }

            .stats-container {
                flex-direction: column;
            }

            .stat-card {
                margin-bottom: 1rem;
            }

            .table th:nth-child(5),
            .table td:nth-child(5),
            .table th:nth-child(6),
            .table td:nth-child(6) {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .table th:nth-child(3),
            .table td:nth-child(3) {
                display: none;
            }

            .table th:nth-child(1), .table td:nth-child(1) { width: 15%; }
            .table th:nth-child(2), .table td:nth-child(2) { width: 30%; }
            .table th:nth-child(4), .table td:nth-child(4) { width: 25%; }
            .table th:nth-child(7), .table td:nth-child(7) { width: 20%; }
            .table th:nth-child(8), .table td:nth-child(8) { width: 10%; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->

    <!-- Main Content -->
    <div class="main-content">
        <div class="card-container">
            <!-- Header Section -->
            <div class="header-section">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0"><i class="fas fa-cubes me-2"></i> Product List</h3>
                    <div class="d-flex gap-3">
                        <form action="/product_list/search" method="GET" class="search-container">
                            <input type="text" name="q" class="form-control" 
                                   placeholder="Search products..." 
                                   value="<?= htmlspecialchars($searchQuery ?? '') ?>">
                        </form>
                        <button class="btn-add"><i class="fas fa-plus me-2"></i>Add Product</button>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="stats-container">
                    <div class="stat-card">
                        <h5>27500</h5>
                        <p>Total Products</p>
                    </div>
                    <div class="stat-card">
                        <h5>4500</h5>
                        <p>In Stock</p>
                    </div>
                    <div class="stat-card">
                        <h5>1500</h5>
                        <p>Low Stock</p>
                    </div>
                    <div class="stat-card orders-hold">
                        <h5>750</h5>
                        <p>Out of Stock</p>
                    </div>
                </div>
            </div>

            <!-- Product Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Stock Name</th>
                            <th>Price</th>
                            <th>Unit</th>
                            <th>Stock ID</th>
                            <th class="text-center">Status</th> <!-- Added Status column -->
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products) && is_array($products)): ?>
                            <?php foreach ($products as $index => $product): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($product['product_name']) ?></td>
                                    <td><?= htmlspecialchars($product['stock_name'] ?? 'N/A') ?></td>
                                    <td>$<?= number_format((float)$product['price'], 2) ?></td>
                                    <td><?= htmlspecialchars($product['unit']) ?></td>
                                    <td><?= htmlspecialchars($product['stock_id'] ?? '') ?></td>
                                    <td class="text-center">
                                        <?php
                                        // Simulate status based on index for demo purposes
                                        $status = $index % 3 == 0 ? 'pending' : ($index % 3 == 1 ? 'paid' : 'hold');
                                        $statusClass = "status-$status";
                                        ?>
                                        <span class="status-badge <?= $statusClass ?>">
                                            <?= ucfirst($status) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="action-menu">
                                            <button class="action-toggle">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <div class="action-options">
                                                <a href="/product_list/edit/<?= $product['product_id'] ?>" 
                                                   class="action-item">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <button class="action-item danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#confirmDeleteModal"
                                                        data-productid="<?= $product['product_id'] ?>">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-box-open me-2"></i> No products found
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i> Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this product? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-custom" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <form id="deleteForm" method="POST">
                        <button type="submit" class="btn btn-danger btn-custom">
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Custom Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var confirmDeleteModal = document.getElementById('confirmDeleteModal');
            confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var productId = button.getAttribute('data-productid');
                var form = document.getElementById('deleteForm');
                form.action = "/product_list/destroy/" + productId;
            });
        });
    </script>
</body>
</html>