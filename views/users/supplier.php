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
                        <th>Create At</th>
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
                                    <!-- Actions like edit and delete can go here -->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Supplier Detail View -->
    <div class="container mt-4 d-none" id="supplierDetailView">
        <div class="card shadow-lg border-light rounded" style="max-width: 600px; margin: 0 auto;">
            <div class="card-header bg-primary text-white">
                <h5 id="supplierDetailName">Supplier Detail</h5>
            </div>
            <div class="card-body bg-light">
                <p><strong>Supplier ID:</strong> <span id="supplierDetailId"></span></p>
                <p><strong>Contact Name:</strong> <span id="supplierDetailContact"></span></p>
                <p><strong>Address:</strong> <span id="supplierDetailAddress"></span></p>
                <p><strong>City:</strong> <span id="supplierDetailCity"></span></p>
                <p><strong>Postal Code:</strong> <span id="supplierDetailPostal"></span></p>
                <p><strong>Phone Number:</strong> <span id="supplierDetailPhone"></span></p>
                <button class="btn btn-secondary mt-3" onclick="goBack()">Back</button>
            </div>
        </div>
    </div>

    <!-- Modal Form for Adding/Editing Supplier -->
    <div class="modal fade" id="supplierModal" tabindex="-1" aria-labelledby="supplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="supplierModalLabel">Add New Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="supplierForm">
                        <input type="hidden" id="editIndex">
                        <div class="mb-3">
                            <label class="form-label">Supplier Name</label>
                            <input type="text" id="supplierName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact Name</label>
                            <input type="text" id="contactName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" id="address" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">City</label>
                            <input type="text" id="city" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Postal Code</label>
                            <input type="text" id="postalCode" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" id="phoneNumber" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success" id="saveButton">Add Supplier</button>
                        <button type="button" class="btn btn-warning d-none" id="updateButton" onclick="updateSupplier()">Update Supplier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    <div id="successMessage" class="alert alert-success text-center position-fixed w-50 start-50 translate-middle-x d-none" style="top: 10px;">
        Supplier updated successfully!
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
