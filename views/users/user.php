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

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
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
    background-color: #007bff;
    color: #fff;
    z-index: 1;
}

tbody tr {
    display: table-row;
}

.dropdown-toggle {
    border: none; /* Remove border around the button */
    background: transparent; /* Make the background transparent */
    padding: 0; /* Remove padding to avoid the circle effect */
    box-shadow: none; /* Remove any shadow around the button */
}

.dropdown-toggle:focus {
    outline: none; /* Remove the focus outline */
}

    </style>
</head>
<body>
<div class="container mt-3 mb-3">
    <!-- User List Card -->
    <div class="table-container">
        <!-- User List Title, Search Bar, and Create User Button -->
        <div class="d-flex justify-content-between align-items-center mb-4 mt-4 ">
            <!-- Title -->
            <h4 class="mb-0"><i class="fas fa-users"></i> User List</h4>

            <!-- Search Bar -->
            <form action="/users/search" method="GET" class="d-flex">
                <div class="input-group" style="width: 400px;"> <!-- Adjust width as needed -->
                    
                    <input type="text" name="search" class="form-control" placeholder="Search for users" value="<?= htmlspecialchars($searchQuery ?? '') ?>">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
            </form>

            <!-- Create User Button -->
            <a href="/users/create" class="btn btn-primary">Create User</a>
        </div>

        <!-- Table with User Data -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-secondary">
                    <tr>
                        <th class="text-white">First Name</th>
                        <th class="text-white">Last Name</th>
                        <th class="text-white">Email</th>
                        <th class="text-white">Role</th>
                        <th class="text-white">Phone</th>
                        <th class="text-center text-white">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['first_name']) ?></td>
                            <td><?= htmlspecialchars($user['last_name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['role']) ?></td>
                            <td><?= htmlspecialchars($user['phone']) ?></td>
                            <td class="text-center">
                                <!-- Action Dropdown -->
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton<?= $user['user_id'] ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton<?= $user['user_id'] ?>">
                                        <li>
                                            <a class="dropdown-item text-primary" href="/users/edit/<?= $user['user_id'] ?>">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form action="/users/destroy/<?= $user['user_id'] ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
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

<!-- Bootstrap 5 JS (Ensure This is Included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>