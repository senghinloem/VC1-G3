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
    <title>Supplier Management</title>

    <!-- Bootstrap Icons (if not already included) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    
    <!-- Bootstrap CSS (needed for styling) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Make the dropdown menu appear when hovering over the button */
        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>
<body>

    <div class="container mt-4" id="supplierListView">
                <!-- Header Card -->
                <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <h4 class="mb-0 d-flex align-items-center">
                            <i class="fas fa-truck me-2 text-primary"></i> Suppliers Management
                        </h4>
                        <div class="d-flex flex-wrap gap-3">
                            <!-- Search Form -->
                            <div class="search-container">
                                <form action="/suppliers/search" method="GET" class="d-flex align-items-center" id="searchForm">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="fas fa-search text-muted"></i>
                                        </span>
                                        <input type="text" name="search" class="form-control border-start-0" 
                                               placeholder="Search for product..." 
                                               id="searchInput">
                                    </div>
                                </form>
                            </div>
                            <!-- Add Supplier Button -->
                            <a href="/supplier/create" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Create Supplier
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-secondary">
                    <tr>
                        <th>Supplier ID</th>
                        <th>Supplier Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($suppliers) && is_array($suppliers)): ?>
                        <?php foreach ($suppliers as $supplier): ?>
                            <tr>
                                <td><?= htmlspecialchars($supplier['supplier_id']) ?></td>
                                <td><?= htmlspecialchars($supplier['supplier_name']) ?></td>
                                <td><?= htmlspecialchars($supplier['email']) ?></td>
                                <td><?= htmlspecialchars($supplier['phone']) ?></td>
                                <td><?= htmlspecialchars($supplier['address']) ?></td>
                                <td><?= htmlspecialchars($supplier['created_at']) ?></td>
                                <td>
                                    <div class="dropdown">
                                        <!-- Three-dot button -->
                                        <button class="btn btn-light border-0 three-dot-btn">
                                            <i class="bi bi-three-dots"></i>
                                        </button>

                                        <!-- Dropdown menu -->
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="/supplier/detail/<?= $supplier['supplier_id']?>">Detail</a></li>
                                            <li><a class="dropdown-item" href="/supplier/edit/<?= $supplier['supplier_id']?>">Edit</a></li>
                                            <li><a class="dropdown-item text-danger" href="/supplier/destroy/<?= $supplier['supplier_id']?>">Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById("searchInput").addEventListener("keyup", function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("tbody tr");
        
            rows.forEach(row => {
                let supplierID = row.cells[0].textContent.toLowerCase(); // Supplier ID
                let supplierName = row.cells[1].textContent.toLowerCase(); // Supplier Name
                let email = row.cells[2].textContent.toLowerCase(); // Email
                let phone = row.cells[3].textContent.toLowerCase(); // Phone
                let address = row.cells[4].textContent.toLowerCase(); // Address
                let createdAt = row.cells[5].textContent.toLowerCase(); // Created At

                // Show row if any of the columns match the filter
                row.style.display = supplierID.includes(filter) || supplierName.includes(filter) || email.includes(filter) || phone.includes(filter) || address.includes(filter) || createdAt.includes(filter) ? "" : "none";
            });
        });
    </script>

</body>
</html>
