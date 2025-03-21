<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit();
}

// Sample data to match the image table (replace with your actual data source
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Orders</title>

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
        }

        body {
            background: var(--light);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }

        /* Sidebar (Offcanvas) */
        .offcanvas {
            background: linear-gradient(135deg, #a1c4fd, #c2e9fb);
            color: var(--primary);
            width: 250px !important;
        }

        .offcanvas .offcanvas-header {
            padding: 1.5rem;
        }

        .offcanvas .offcanvas-title {
            font-size: 1.2rem;
            font-weight: 700;
        }

        .offcanvas .nav-link {
            color: var(--primary);
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .offcanvas .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .offcanvas .nav-link i {
            margin-right: 0.5rem;
        }

        .offcanvas .nav-link.logout {
            color: var(--danger);
        }

        /* User Profile in Sidebar */
        .user-profile {
            text-align: center;
            margin-bottom: 2rem;
        }

        .user-profile img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-bottom: 0.5rem;
        }

        .user-profile p {
            margin: 0;
            font-size: 1rem;
            font-weight: 500;
        }

        /* Main Content */
        .main-content {
            padding: 2rem;
        }

        .card-container {
            background: var(--white);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Statistics Cards */
        .stat-card {
            background: var(--white);
            border-radius: 10px;
            padding: 1.5rem;
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

        /* Table Styling */
        .table th, .table td {
            vertical-align: middle;
            border: none; /* Remove borders to match the image */
            padding: 0.75rem; /* Match padding in the image */
        }

        .table thead th {
            background: #f8f9fa; /* Light gray header background */
            color: var(--primary);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        .table tbody tr {
            background: #f8f9fa; /* Light gray background for rows */
        }

        .table tbody tr:hover {
            background: #e9ecef; /* Slightly darker on hover */
        }

        /* Action Dropdown Styling */
        .action-btn {
            background: transparent;
            border: 1px solid #ced4da;
            border-radius: 4px;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease;
        }

        .action-btn:hover {
            background: #e9ecef;
        }

        .dropdown-menu {
            border: none;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 0.25rem 0;
            min-width: 120px;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .dropdown-item i {
            margin-right: 0.5rem;
            font-size: 0.9rem;
        }

        .dropdown-item.edit {
            color: var(--secondary);
        }

        .dropdown-item.danger {
            color: #343a40; /* Dark gray to match the image */
        }

        .dropdown-item:hover {
            background: #f8f9fa;
        }

        .dropdown-item.edit:hover {
            color: #2980b9;
        }

        .dropdown-item.danger:hover {
            color: #212529;
        }
    </style>
</head>
<body>
    <!-- Sidebar (Offcanvas) -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">PNN SHOP</h5>
            <button type="button" class="btn-close btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <!-- User Profile -->
            <div class="user-profile">
                <img src="https://via.placeholder.com/60" alt="User Avatar">
                <p>John Smith</p>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-tachometer-alt"></i> Overview</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-box"></i> Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-users"></i> Customers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-list"></i> Menus</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-box-open"></i> Packages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-envelope"></i> Messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link logout" href="#"><i class="fas fa-sign-out-alt"></i> Sign Out</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="card-container">
            <!-- Header Section -->
            <div class="header-section">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0"><i class="fas fa-cubes me-2"></i> Restaurant Orders</h3>
                    <div class="d-flex gap-3">
                        <form action="/orders/search" method="GET" class="search-container">
                            <input type="text" name="q" class="form-control rounded-pill" 
                                   placeholder="Search orders..." 
                                   value="<?= htmlspecialchars($searchQuery ?? '') ?>">
                        </form>
                        <button class="btn btn-primary rounded-pill btn-add"><i class="fas fa-plus me-2"></i>Add New Order</button>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row row-cols-1 row-cols-md-4 g-4 mb-4">
                    <div class="col">
                        <div class="stat-card">
                            <h5>27500</h5>
                            <p>Total Orders</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="stat-card">
                            <h5>4500</h5>
                            <p>Total Delivered</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="stat-card">
                            <h5>1500</h5>
                            <p>Pending Orders</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="stat-card orders-hold">
                            <h5>750</h5>
                            <p>Orders Hold</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Unit</th>
                            <th scope="col">Stock ID</th>
                            <th scope="col">Stock Name</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products) && is_array($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?= htmlspecialchars($product['product_id']) ?></td>
                                    <td><?= htmlspecialchars($product['product_name']) ?></td>
                                    <td>$<?= number_format((float)$product['price'], 2) ?></td>
                                    <td><?= htmlspecialchars($product['unit']) ?></td>
                                    <td><?= htmlspecialchars($product['stock_id'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($product['stock_name'] ?? 'N/A') ?></td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="action-btn" type="button" id="dropdownMenuButton-<?= $product['product_id'] ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-<?= $product['product_id'] ?>">
                                                <li>
                                                    <a class="dropdown-item edit" href="/product_list/edit/<?= htmlspecialchars($product['product_id']) ?>">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item danger" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#confirmDeleteModal"
                                                            data-productid="<?= htmlspecialchars($product['product_id']) ?>">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4">
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
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i> Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this product? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <form id="deleteForm" method="POST">
                        <button type="submit" class="btn btn-danger rounded-pill">
                            <i class="fas fa-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
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