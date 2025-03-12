<div class="container">
<form action="/users/store" method="POST">
    <div class="mb-2">
        <label for="firstName" class="form-label small">First Name</label>
        <input type="text" class="form-control form-control-sm" id="firstName" name="first_name" required>
    </div>
    <div class="mb-2">
        <label for="lastName" class="form-label small">Last Name</label>
        <input type="text" class="form-control form-control-sm" id="lastName" name="last_name" required>
    </div>
    <div class="mb-2">
        <label for="email" class="form-label small">Email</label>
        <input type="email" class="form-control form-control-sm" id="email" name="email" required>
    </div>
    <div class="mb-2">
        <label for="password" class="form-label small">Password</label>
        <input type="password" class="form-control form-control-sm" id="password" name="password" required>
    </div>
    <div class="mb-2">
        <label for="role" class="form-label small">Role</label>
        <select class="form-select form-select-sm" id="role" name="role" required>
            <option value="" disabled selected>Select role</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
            <option value="editor">Editor</option>
        </select>
    </div>
    <div class="mb-2">
        <label for="phone" class="form-label small">Phone</label>
        <input type="tel" class="form-control form-control-sm" id="phone" name="phone">
    </div>
    <button type="submit" class="btn btn-primary btn-sm w-100"><i class="bi bi-person-plus"></i> Create</button>
</form>

</div>
