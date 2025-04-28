<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
    body {
        background-color: #f9fafb;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .main-container {
        max-width: 1400px;
        margin: 2rem auto;
        padding: 0 2rem;
    }

    .category-header {
        color: #6c63ff;
        font-weight: 600;
        font-size: 2.25rem;
        margin-bottom: 0;
    }

    .table-container {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-top: 1.5rem;
    }

    .table {
        margin-bottom: 0;
        table-layout: fixed;
    }

    .table thead th {
        background-color: #f1f1f9;
        color: #6c757d;
        font-weight: 500;
        border-bottom: none;
        padding: 1.25rem;
    }

    .table tbody td {
        padding: 1.25rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f1f9;
    }

    .add-btn {
        color: #6c63ff;
        border: 1px solid #6c63ff;
        background-color: white;
        border-radius: 10px;
        padding: 10px 24px;
        font-size: 16px;
        font-weight: 500;
        transition: all 0.2s ease;
        text-decoration: none;
        /* Remove underline */
    }

    .add-btn:hover {
        background-color: #6c63ff;
        color: white;
        text-decoration: none;
        /* Ensure no underline on hover */
    }

    .add-btn i {
        margin-right: 8px;
        font-size: 1.1rem;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 0;
        color: #6c757d;
    }

    /* Column width specifications */
    .col-name {
        width: 45%;
    }

    .col-date {
        width: 35%;
    }

    .col-action {
        width: 20%;
    }

    /* Action Menu Styling */
    .action-menu {
        position: relative;
        display: inline-block;
    }

    .kebab-menu {
        width: 56px;
        height: 56px;
        border-radius: 10px;
        background-color: #f8f9fa;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .kebab-menu:hover {
        background-color: #f1f1f9;
        transform: translateY(-2px);
    }

    .kebab-menu:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(108, 99, 255, 0.25);
    }

    .kebab-menu i {
        font-size: 1.5rem;
        color: #6c757d;
    }

    .dropdown-menu {
        min-width: 200px;
        padding: 0.5rem 0;
        border: none;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        margin-top: 0.5rem;
    }

    .dropdown-item {
        padding: 0.75rem 1.25rem;
        font-size: 1rem;
        display: flex;
        align-items: center;
        transition: all 0.2s ease;
    }

    .dropdown-item i {
        margin-right: 10px;
        font-size: 1.1rem;
        width: 20px;
        text-align: center;
    }

    .dropdown-item.edit {
        color: #28a745;
    }

    .dropdown-item.delete {
        color: #dc3545;
    }

    .dropdown-item.view {
        color: #17a2b8;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }

    .dropdown-item.edit:hover {
        background-color: rgba(40, 167, 69, 0.1);
    }

    .dropdown-item.delete:hover {
        background-color: rgba(220, 53, 69, 0.1);
    }

    .dropdown-item.view:hover {
        background-color: rgba(23, 162, 184, 0.1);
    }

    .alert {
        margin-top: 1rem;
    }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="category-header">Category</h2>
            <a href="/category/create" class="add-btn">
                <i class="bi bi-plus-circle"></i> Add new Category
            </a>
        </div>

        <?php if (isset($data['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($data['success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <?php if (isset($data['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($data['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="col-name">Category Name</th>
                        <th scope="col" class="col-date">Create Date</th>
                        <th scope="col" class="col-action text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($data['categories']) && count($data['categories']) > 0): ?>
                    <?php foreach ($data['categories'] as $category): ?>
                    <tr>
                        <td><?= htmlspecialchars($category["category_name"]) ?></td>
                        <td><?= htmlspecialchars(date('F j, Y, g:i a', strtotime($category["created_at"]))) ?></td>
                        <td class="text-end">
                            <div class="action-menu">
                                <button class="kebab-menu" type="button" id="action-<?= $category['category_id'] ?>"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end"
                                    aria-labelledby="action-<?= $category['category_id'] ?>">
                                    <li><a class="dropdown-item edit"
                                            href="/category/edit/<?= $category['category_id'] ?>">
                                            <i class="bi bi-pencil-fill"></i> Edit
                                        </a></li>
                                    <li><a class="dropdown-item delete"
                                            href="/category/delete/<?= $category['category_id'] ?>"
                                            onclick="return confirm('Are you sure you want to delete this category?')">
                                            <i class="bi bi-trash-fill"></i> Delete
                                        </a></li>
                                    <li><a class="dropdown-item view"
                                            href="/categories/category/show/<?= $category['category_id'] ?>">
                                            <i class="bi bi-eye-fill"></i> View
                                        </a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="3">
                            <div class="empty-state">
                                <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
                                <p>No categories found. Click "Add new Category" to create one.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>