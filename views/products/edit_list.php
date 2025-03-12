<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ...existing code... -->
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Edit Product</h4>
                <p class="mb-0">Edit product details</p>
            </div>
            <div class="card-body">
                <?php if (isset($list) && is_array($list)): ?>
                <form action="/product_list/update/<?php echo $list['product_list_id']; ?>" method="POST" enctype="multipart/form-data">
                    <div class="row g-3">   
                        <div class="col-md-12">
                            <label class="form-label">Product Image</label>
                            <div class="image-upload">
                                <img src="<?php echo $list['image']; ?>" alt="Product Image" width="100">
                                <p>Drag and drop a file to upload</p>
                                <input type="file" class="form-control d-none" name="product_image" id="product_image">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Available Quantity</label>
                            <input type="text" class="form-control" id="available" name="available_quantity" value="<?php echo $list['available_quantity']; ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Product Quantity</label>
                            <input type="text" class="form-control" id="quantity" name="price" value="<?php echo $list['price']; ?>">
                        </div>
                        <div class="col-md-12 d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="/product_list" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
                <?php else: ?>
                <p>Product details not available.</p>
                <?php endif; ?>
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