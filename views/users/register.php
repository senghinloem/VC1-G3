
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-lg-6">
            <div class="card p-4 shadow-sm">
                <h2 class="text-center fw-bold mb-4">Create Account</h2>
                <form class="needs-validation" novalidate>
                    <!-- Name Field -->
                    <div class="mb-3">
                        <label for="name" class="form-label">First Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" id="name" class="form-control" placeholder="Enter your name" required>
                            <div class="invalid-feedback">Please enter your name.</div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Last Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" id="name" class="form-control" placeholder="Enter your name" required>
                            <div class="invalid-feedback">Please enter your name.</div>
                        </div>
                    </div>
                    <!-- Email Field -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Your Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" id="email" class="form-control" placeholder="Enter your email" required>
                            <div class="invalid-feedback">Please enter a valid email.</div>
                        </div>
                    </div>
                    
                    <!-- Password Field -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" id="password" class="form-control" placeholder="Enter your password" required>
                            <div class="invalid-feedback">Please enter a password.</div>
                        </div>
                    </div>
                    
                    <!-- Confirm Password Field -->
                    <div class="mb-3">
                        <label for="confirm-password" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                            <input type="password" id="confirm-password" class="form-control" placeholder="Confirm your password" required>
                            <div class="invalid-feedback">Passwords must match.</div>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        (function () {
            'use strict';
            let form = document.querySelector('.needs-validation');
            let password = document.getElementById("password");
            let confirmPassword = document.getElementById("confirm-password");
            
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity() || password.value !== confirmPassword.value) {
                    event.preventDefault();
                    event.stopPropagation();
                    
                    if (password.value !== confirmPassword.value) {
                        confirmPassword.setCustomValidity("Passwords do not match.");
                    } else {
                        confirmPassword.setCustomValidity("");
                    }
                }
                form.classList.add('was-validated');
            });
            
            confirmPassword.addEventListener('input', function () {
                if (password.value === confirmPassword.value) {
                    confirmPassword.setCustomValidity("");
                } else {
                    confirmPassword.setCustomValidity("Passwords do not match.");
                }
            });
        })();
    </script>

