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
        .image-upload {
            border: 2px dashed #ccc;
            border-radius: 10px;
            text-align: center;
            padding: 30px;
            cursor: pointer;
            transition: border-color 0.3s;
        }
        .image-upload:hover {
            border-color: #007bff;
        }
        .image-upload img {
            width: 50px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Product Add</h4>
                <p class="mb-0">Create new product</p>
            </div>
            <div class="card-body">
                <form action="/product_list/store" method="POST" enctype="multipart/form-data">
                    <div class="row g-3">   
                        <div class="col-md-12">
                            <label class="form-label">Product Image</label>
                            <div class="image-upload">
        <img src="views/assets/images/upload.svg" alt="Upload Icon">
        <p>Drag and drop a file to upload</p>
        <input type="file" class="form-control d-none" name="product_image" id="product_image">
    </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Available Quantity</label>
                            <input type="text" class="form-control" id="available" name="available_quantity">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Product Quantity</label>
                            <input type="text" class="form-control" id="quantity" name="price">
                        </div>
                        <div class="col-md-12 d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="productlist.html" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('.image-upload').addEventListener('click', function() {
            this.querySelector('input[type=file]').click();
        });
    </script>
</body>
</html>