<style> 
    .container {
        width: 600px;
    }
</style>

<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body p-4">
            <h4 class="text-center text-primary mb-3"><i class="bi bi-person-plus"></i> Create User</h4>
            
            <form action="/users/store" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName" class="form-label fw-semibold">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="first_name" placeholder="Enter first name" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName" class="form-label fw-semibold">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Enter last name" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label fw-semibold">Role</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="" disabled selected>Select a role</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                        <option value="editor">Editor</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label fw-semibold">Phone</label>
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter phone number">
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold">
                    <i class="bi bi-check-circle"></i> Submit
                </button>
            </form>
        </div>
    </div>
</div>
