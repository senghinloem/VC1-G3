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
    <title>User Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .table-container {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .dropdown-toggle::after {
            display: none;
        }
        .dropdown-menu {
            min-width: 150px;
        }
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .table-responsive {
            max-height: 500px;
            overflow-y: auto;
        }
        table {
            width: 100%;
        }
        table tbody {
            display: block;
            max-height: 320px;
            overflow-y: auto;
        }
        table thead, table tbody tr {
            display: table;
            width: 100%;
            table-layout: fixed;
        }
        thead th {
            position: sticky;
            top: 0;
            color: #fff;
            z-index: 1;
        }
        tbody tr {
            display: table-row;
        }
        .dropdown-toggle {
            border: none;
            background: transparent;
            padding: 0;
            box-shadow: none;
        }
        .dropdown-toggle:focus {
            outline: none;
        }
        /* Define explicit column widths */
        th:nth-child(1), td:nth-child(1) { /* Image */
            width: 10%;
        }
        th:nth-child(2), td:nth-child(2) { /* First Name */
            width: 15%;
        }
        th:nth-child(3), td:nth-child(3) { /* Last Name */
            width: 15%;
        }
        th:nth-child(4), td:nth-child(4) { /* Email */
            width: 25%;
        }
        th:nth-child(5), td:nth-child(5) { /* Role */
            width: 15%;
        }
        th:nth-child(6), td:nth-child(6) { /* Phone */
            width: 15%;
        }
        th:nth-child(7), td:nth-child(7) { /* Actions */
            width: 5%;
        }
        /* Use padding-left instead of margin-left for Role column */
        .role-column {
            padding-left: 20px;
        }
    </style>
</head>
<body>
<div class="container mt-3 mb-3">
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
            <h4 class="mb-0"><i class="fas fa-users"></i> User List</h4>
            <form action="/users/search" method="GET" class="d-flex">
                <div class="input-group" style="width: 400px;">
                    <input type="text" name="search" class="form-control" placeholder="Search for users" value="<?= htmlspecialchars($searchQuery ?? '') ?>">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
            </form>
            <a href="/users/create" class="btn btn-primary">Create User</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-secondary">
                    <tr>
                        <th class="text-white">Image</th>
                        <th class="text-white">First Name</th>
                        <th class="text-white">Last Name</th>
                        <th class="text-white">Email</th>
                        <th class="text-white role-column">Role</th>
                        <th class="text-white">Phone</th>
                        <th class="text-center text-white">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <?php if ($user['image']): ?>
                                    <img src="/uploads/<?= htmlspecialchars($user['image']) ?>" 
                                         alt="Profile" 
                                         style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                <?php else: ?>
                                    <i class="fas fa-user-circle" style="font-size: 40px;"></i>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($user['first_name']) ?></td>
                            <td><?= htmlspecialchars($user['last_name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td class="role-column"><?= htmlspecialchars($user['role']) ?></td>
                            <td><?= htmlspecialchars($user['phone']) ?></td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton<?= $user['user_id'] ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?= $user['user_id'] ?>">
                                        <li>
                                            <a class="dropdown-item" href="/users/edit/<?= $user['user_id'] ?>">
                                                <i class="fas fa-edit text-primary"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" 
                                                    data-userid="<?= $user['user_id'] ?>">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap Delete Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <form id="deleteForm" method="POST">
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to Update Form Action -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var confirmDeleteModal = document.getElementById('confirmDeleteModal');
        confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var userId = button.getAttribute('data-userid');
            var form = document.getElementById('deleteForm');
            form.action = "/users/destroy/" + userId;
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>