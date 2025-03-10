
    <style>
        body {
            background: linear-gradient(to bottom, #FFFFFF, #D9D9D9);
        }
        .hero-text h1 {
            font-size: 30px;
            font-weight: bold;
            line-height: 1.4;
        }
        .highlight {
            color: #FF1493;
        }
        .start-btn {
            background: linear-gradient(to right, #FF1493, #2C8CFB);
            color: white;
            border-radius: 20px;
        }
        .menu {
            background: #2C8CFB;
            color: white;
            border-radius: 15px;
            max-width: 1000px;
            margin-top: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg py-3">
            <a class="navbar-brand fw-bold text-primary" href="#">PNN</a>
            <div class="ms-auto">
                <a href="register" class="btn btn-outline-primary me-2">Register</a>
                <a href="/login" class="btn btn-primary">Login</a>
            </div>
        </nav>

        <div class="row align-items-center text-start py-5">
            <div class="col-md-6">
                <h1><strong>Free</strong> <span class="highlight">Inventory</span> management software <br> for small businesses</h1>
                <!-- <button class="btn start-btn mt-3 px-4 py-2">Start</button> -->
                <a href="/login" class="btn start-btn mt-3 px-4 py-2">Start</a>
            </div>
            <div class="col-md-6 text-center">
                <img src="views/assets/images/inventory-illustration.png" alt="Inventory Management Illustration" class="img-fluid" style="max-width: 400px;">
            </div>
        </div>

        <div class="menu d-flex justify-content-between px-4 py-3 mx-auto">
            <div class="text-center"><i class="fas fa-list"></i> Category</div> |
            <div class="text-center"><i class="fas fa-arrow-down"></i> Item In</div> |
            <div class="text-center"><i class="fas fa-arrow-up"></i> Item Out</div> |
            <div class="text-center"><i class="fas fa-user"></i> Manager</div> |
            <div class="text-center"><i class="fas fa-box"></i> Stock</div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
