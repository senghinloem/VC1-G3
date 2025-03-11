<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <style>
        body {
            background-color: #f4f6f9;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: #fff;
            text-align: center;
            padding: 20px;
            border-radius: 12px 12px 0 0;
        }
        .image-upload {
            border: 2px dashed #ccc;
            border-radius: 10px;
            text-align: center;
            padding: 20px;
            cursor: pointer;
            background-color: #fff;
            transition: all 0.3s;
        }
        .image-upload:hover {
            border-color: #007bff;
            background-color: #f1f1f1;
        }
        .image-upload img {
            width: 100px;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        #preview {
            display: none;
            width: 100px;
            border-radius: 10px;
            margin-top: 10px;
        }
        .btn {
            border-radius: 8px;
            font-weight: bold;
            padding: 10px 15px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Edit Product</h4>
                <p class="mb-0">Modify product details below</p>
            </div>
            <div class="card-body">
                <?php if (isset($list) && is_array($list)): ?>
                <form action="/product_list/update/<?php echo $list['product_list_id']; ?>" method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Product Image</label>
                            <div class="image-upload" onclick="document.getElementById('product_image').click();">
                                <img id="preview" src="<?php echo $list['image']; ?>" alt="Product Image">
                                <p>Click or Drag to Upload</p>
                                <input type="file" class="form-control d-none" name="product_image" id="product_image" onchange="previewImage(event)">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="name" value="<?php echo $list['name']; ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Available Quantity</label>
                            <input type="number" class="form-control" name="available_quantity" value="<?php echo $list['available_quantity']; ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Price ($)</label>
                            <input type="text" class="form-control" name="price" value="<?php echo $list['price']; ?>" required>
                        </div>
                        <div class="col-md-12 d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                            <a href="/product_list" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
                        </div>
                    </div>
                </form>
                <?php else: ?>
                <p class="text-center text-danger">Product details not available.</p>
                <?php endif; ?>
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