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
        }
        .table-container {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .dropdown-toggle::after {
            display: none;
        }
        .dropdown-menu {
            min-width: 120px;
        }
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
    </style>
</head>
<body>

<div class="container mt-3 mb-3">
    <!-- User List Card -->
    <div class="table-container">
        <!-- Search Bar -->
        <form action="/users/search" method="GET" class="d-flex mb-3">
            <input type="text" name="search" class="form-control w-50" placeholder="Search for users" value="<?= htmlspecialchars($searchQuery ?? '') ?>">
            <button type="submit" class="btn btn-primary ms-2"><i class="fas fa-search"></i> Search</button>
        </form>

        <!-- User List Title -->
        <h4 class="mb-3 text-primary"><i class="fas fa-users"></i> User List</h4>
        

        <div class="table-responsive">
        <a href="/users/create" class="btn btn-primary mb-2">Create User</a>
            <table class="table table-hover align-middle">
                <thead class="text-white">
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Phone</th>
                        <th class="text-center">Actions</th>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>