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
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#supplierModal" onclick="openAddModal()">+ Add New Supplier</button>
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
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewSupplierModal" onclick="viewSupplier(<?= htmlspecialchars(json_encode($supplier)) ?>)">Details</button>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateSupplierModal" onclick="editSupplier(<?= htmlspecialchars(json_encode($supplier)) ?>)">Update</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteSupplier(<?= $supplier['supplier_id'] ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form for Adding Supplier -->
    <div class="modal fade" id="supplierModal" tabindex="-1" aria-labelledby="supplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="supplierModalLabel">Add New Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="supplierForm">
                        <div class="mb-3">
                            <label class="form-label">Supplier Name</label>
                            <input type="text" id="supplierName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" id="phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" id="address" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success">Add Supplier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Viewing Supplier Details -->
    <div class="modal fade" id="viewSupplierModal" tabindex="-1" aria-labelledby="viewSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Supplier Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="supplierDetails"></div>
            </div>
        </div>
    </div>

    <!-- Modal Form for Updating Supplier -->
    <div class="modal fade" id="updateSupplierModal" tabindex="-1" aria-labelledby="updateSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateSupplierForm">
                        <input type="hidden" id="editSupplierId">
                        <div class="mb-3">
                            <label class="form-label">Supplier Name</label>
                            <input type="text" id="editSupplierName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" id="editEmail" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" id="editPhone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" id="editAddress" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-warning">Update Supplier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function viewSupplier(supplier) {
            const details = `
                <p><strong>Supplier ID:</strong> ${supplier.supplier_id}</p>
                <p><strong>Name:</strong> ${supplier.supplier_name}</p>
                <p><strong>Email:</strong> ${supplier.email}</p>
                <p><strong>Phone:</strong> ${supplier.phone}</p>
                <p><strong>Address:</strong> ${supplier.address}</p>
                <p><strong>Created At:</strong> ${supplier.created_at}</p>
            `;
            document.getElementById('supplierDetails').innerHTML = details;
        }
    </script>
</body>
</html>
