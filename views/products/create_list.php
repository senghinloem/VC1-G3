<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <style>
        body {
            background-color: #eef2f7;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        .card-header {
            background: #007bff;
            color: #fff;
            border-radius: 12px 12px 0 0;
            padding: 20px;
            text-align: center;
        }

        .image-upload {
            border: 2px dashed #007bff;
            border-radius: 10px;
            text-align: center;
            padding: 30px;
            cursor: pointer;
            background-color: #fafafa;
            transition: 0.3s;
        }

        .image-upload:hover {
            background-color: #e9f5ff;
        }

        .image-upload img {
            width: 60px;
            margin-bottom: 10px;
        }

        #preview {
            display: none;
            width: 100%;
            max-height: 250px;
            object-fit: cover;
            border-radius: 10px;
            margin-top: 10px;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn {
            border-radius: 8px;
            padding: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-header">
                <h4 class="mb-0">Add New Product</h4>
            </div>
            <div class="card-body">
                <form action="/product_list/store" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Product Image</label>
                        <div class="image-upload" onclick="document.getElementById('product_image').click();">
                        <img src="https://cdn-icons-png.flaticon.com/512/1828/1828490.png" alt="Upload Icon" width="80">

                            <p>Click to Upload</p>
                            <input type="file" class="form-control d-none" name="product_image" id="product_image" onchange="previewImage(event)">
                        </div>
                        <img id="preview" alt="Image Preview">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Available Quantity</label>
                        <input type="number" class="form-control" name="available_quantity" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price ($)</label>
                        <input type="text" class="form-control" name="price" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/product_list" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            let reader = new FileReader();
            reader.onload = function () {
                let preview = document.getElementById('preview');
                preview.src = reader.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>