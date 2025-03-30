<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            background: linear-gradient(to bottom, #FFFFFF, #F3F3F3);
            display: flex;
            flex-direction: column;
        }
        .container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .hero-text h1 {
            font-size: 34px;
            font-weight: bold;
            line-height: 1.4;
            color: #333;
        }
        .highlight {
            color: #FF1493;
        }
        .start-btn {
            background: linear-gradient(to right, #FF1493, #2C8CFB);
            color: white;
            border-radius: 25px;
            padding: 12px 25px;
            transition: 0.3s;
            font-size: 18px;
        }
        .start-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .menu {
            background: #2C8CFB;
            color: white;
            border-radius: 15px;
            max-width: 1000px;
            margin-top: 50px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            padding: 0;
        }
        .menu div {
            flex: 1;
            padding: 15px 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 18px;
            border-right: 2px solid rgba(255, 255, 255, 0.5);
            text-align: center;
        }
        .menu div:last-child {
            border-right: none;
        }
        .menu div:hover {
            background: rgba(255, 255, 255, 0.2);
            height: 100%;
            border-radius: 15px 15px 0 0;
        }
    </style>
</head>
<body>
    <div class="container mb-3">
        <nav class="navbar navbar-expand-lg py-3">
            <a class="navbar-brand fw-bold text-primary" href="#">PNN</a>
            <div class="ms-auto">
                <!-- <a href="/register" class="btn btn-outline-primary me-2">Register</a> -->
                <!-- <a href="/login" class="btn btn-primary">Login</a> -->
            </div>
        </nav>

        <div class="row align-items-center text-start py-5">
            <div class="col-md-6">
                <h1><strong>Free</strong> <span class="highlight">Inventory</span> management software <br> for small businesses</h1>
                <a href="/login" class="btn start-btn mt-3">Start</a>
            </div>
            <div class="col-md-6 text-center">
                <img src="views/assets/images/inventory-illustration.png" alt="Inventory Management Illustration" class="img-fluid" style="max-width: 400px;">
            </div>
        </div>

        <div class="menu mx-auto">
            <div class="text-center"><i class="fas fa-list"></i> Category</div>
            <div class="text-center"><i class="fas fa-arrow-down"></i> Item In</div>
            <div class="text-center"><i class="fas fa-arrow-up"></i> Item Out</div>
            <div class="text-center"><i class="fas fa-user"></i> Manager</div>
            <div class="text-center"><i class="fas fa-box"></i> Stock</div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
