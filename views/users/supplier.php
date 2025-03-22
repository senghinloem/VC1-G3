<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4" id="supplierListView">
        <div class="d-flex justify-content-between align-items-center mb-3">

            <input type="text" id="searchInput" class="form-control w-50" placeholder="Search for supplier...">
            <a href="/supplier/create" class="btn btn-info">+ Add New Supplier</a>

        </div>

        <h4>Suppliers List</h4>
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
                                <style>
                                /* Make the dropdown menu appear when hovering over the button */
                                .dropdown:hover .dropdown-menu {
                                    display: block;
                                }
                                </style>
                                </td>
                            </tr>
                            
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
