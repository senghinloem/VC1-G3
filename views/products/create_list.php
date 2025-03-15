<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["product_image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["product_image"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars(basename($_FILES["product_image"]["name"])). " has been uploaded.";
                // Save the file path to the database
                $product_image = $target_file;
                // ...existing code to save other form data to the database...
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    ?>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            margin: 0;
        }

        .container {
            margin-top: 30px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 15px 25px;
        }

        .card-body {
            padding: 25px;
        }

        .form-label {
            font-weight: 600;
            color: #343a40;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #ccc;
        }

        .upload-container {
            border: 2px solid #007bff;
            border-radius: 10px;
            padding: 20px;
            background-color: #f8f9fa;
            text-align: center;
            margin-bottom: 15px;
        }

        .upload-container:hover {
            border-color: #0056b3;
        }

        .upload-button {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .upload-button:hover {
            background-color: #0056b3;
        }

        .image-preview {
            margin-top: 15px;
            display: none;
            border-radius: 10px;
            width: 100%;
            height: auto;
        }

        .col-md-3 {
            padding-bottom: 15px;
        }

        .d-flex.justify-content-end {
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 25px;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }


        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>

    </head>
    <body>
        <div class="container mt-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Add New Product</h4>
                    <p class="mb-0">Create a new product entry</p>
                </div>
                <div class="card-body">
                    <form action="/product_list/store" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <!-- Product Image Upload Section -->
                            <div class="col-md-12">
                                <label class="form-label">Product Image</label>
                                <div class="upload-container">
                                    <input type="file" name="product_image" id="product_image" class="d-none" accept="image/*" onchange="previewImage(event)">
                                    <label for="product_image" class="upload-button">Browse for Image</label>
                                    <div id="imagePreviewContainer">
                                        <img id="imagePreview" class="image-preview" />
                                    </div>
                                </div>
                            </div>
                            <!-- Product Name -->
                            <div class="col-md-3">
                                <label class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <!-- Available Quantity -->
                            <div class="col-md-3">
                                <label class="form-label">Available Quantity</label>
                                <input type="number" class="form-control" id="available" name="available_quantity" required>
                            </div>
                            <!-- Product Price -->
                            <div class="col-md-3">
                                <label class="form-label">Price ($)</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                            </div>
                            <!-- Submit and Cancel buttons -->
                            <div class="col-md-12 d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="/product_list" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bootstrap 5 JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            function previewImage(event) {
                const preview = document.getElementById('imagePreview');
                const file = event.target.files[0];
                const reader = new FileReader();
                reader.onload = function () {
                    preview.src = reader.result;
                    preview.style.display = 'block'; // Show the image preview
                };
                if (file) {
                    reader.readAsDataURL(file); // Convert the image to base64 and display it
                }
            }
        </script>
    </body>
    </html>
