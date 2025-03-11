<div class="container mt-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <input type="text" class="form-control w-50" placeholder="Search for users">
        <a href="/users/create" class="btn btn-primary">+ Add New User</a>
    </div>

    <h4 class="mb-3"><i class="bi bi-person"></i> User List</h4>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-secondary">
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Phone</th>
                    <th>Action</th>
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
                        <td>
                            <a href="/users/edit/<?= $user['user_id'] ?>" class="btn btn-primary text-white"><i class="fas fa-edit"></i></a>
                            <form action="/users/destroy/<?= $user['user_id'] ?>" method="POST" style="display:inline;">
                                <!-- Add a hidden field for the delete action method -->
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
