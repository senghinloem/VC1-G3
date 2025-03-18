
<style>
    .container {
        width: 600px;
    }
</style>

<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-1">
        <div class="card-body p-2">
            <h6 class="text-center text-primary mb-2"><i class="bi bi-pencil-square"></i> Edit User</h6>

            <form action="/users/update/<?= $user['user_id'] ?>" method="POST">
                <div class="row g-1">
                    <div class="col-6">
                        <label for="firstName" class="form-label small mb-0">First Name</label>
                        <input type="text" class="form-control form-control-sm" id="firstName" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
                    </div>
                    <div class="col-6">
                        <label for="lastName" class="form-label small mb-0">Last Name</label>
                        <input type="text" class="form-control form-control-sm" id="lastName" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
                    </div>
                </div>

                <div class="mt-1">
                    <label for="email" class="form-label small mb-0">Email</label>
                    <input type="email" class="form-control form-control-sm" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>

                <div class="mt-1">
                    <label for="password" class="form-label small mb-0">Password</label>
                    <div class="input-group input-group-sm">
                        <input type="password" class="form-control" id="password" name="password" required>
                        <button class="btn btn-outline-secondary btn-sm px-2" type="button" id="togglePassword">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                </div>

                <div class="mt-1">
                    <label for="role" class="form-label small mb-0">Role</label>
                    <select class="form-select form-select-sm" id="role" name="role" required>
                        <option value="" disabled>Select role</option>
                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                        <option value="editor" <?= $user['role'] === 'editor' ? 'selected' : '' ?>>Editor</option>
                    </select>
                </div>

                <div class="mt-1">
                    <label for="phone" class="form-label small mb-0">Phone</label>
                    <input type="tel" class="form-control form-control-sm" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">
                </div>

                <div class="d-grid gap-1 mt-2">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-save"></i> Update</button>
                    <a href="/users" class="btn btn-warning btn-sm"><i class="bi bi-x-circle"></i> Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Password Show/Hide Script -->
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        let passwordField = document.getElementById('password');
        let icon = this.querySelector('i');
        passwordField.type = passwordField.type === "password" ? "text" : "password";
        icon.classList.toggle("bi-eye");
        icon.classList.toggle("bi-eye-slash");
    });
</script>
