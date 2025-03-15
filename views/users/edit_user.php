<div class="container">
    <form action="/users/update/<?= $user['user_id'] ?>" method="POST">
        <h2>Edit User</h2>
        <div class="mb-2">
            <label for="firstName" class="form-label small">First Name</label>
            <input type="text" class="form-control form-control-sm" id="firstName" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
        </div>
        <div class="mb-2">
            <label for="lastName" class="form-label small">Last Name</label>
            <input type="text" class="form-control form-control-sm" id="lastName" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
        </div>
        <div class="mb-2">
            <label for="email" class="form-label small">Email</label>
            <input type="email" class="form-control form-control-sm" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div class="mb-2">
            <label for="password" class="form-label small">Password</label>
            <input type="password" class="form-control form-control-sm" id="password" name="password" required>
        </div>
        <div class="mb-2">
            <label for="role" class="form-label small">Role</label>
            <select class="form-select form-select-sm" id="role" name="role" required>
                <option value="" disabled>Select role</option>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                <option value="editor" <?= $user['role'] === 'editor' ? 'selected' : '' ?>>Editor</option>
            </select>
        </div>
        <div class="mb-2">
            <label for="phone" class="form-label small">Phone</label>
            <input type="tel" class="form-control form-control-sm" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">
        </div>
        <button type="submit" class="btn btn-primary mb-3">Update</button>
        <a href="/users" class="btn btn-warning mb-3">Cancel</a>
    </form>
</div>
