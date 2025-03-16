<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Add</title>
    <style>
        .image-upload {
            border: 2px dashed #ccc;
            border-radius: 10px;
            text-align: center;
            padding: 30px;
            cursor: pointer;
            transition: border-color 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 150px; 
            position: relative;
        }
        .image-upload:hover {
            border-color: #007bff;
        }
        .image-upload {
            width: 100%;
            margin-bottom: 10px;
        }

        .image-upload img.preview {
            max-width: 100%;
            max-height: 150px;
            object-fit: contain;
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
                <form  action="/products/store" method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        
                        <div class="col-md-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Product Quantity</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Description</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Stock Location</label>
                            <input type="text" class="form-control">
                        </div>

                    

                        <div class="col-md-12">
                            <label class="form-label">Product Image</label>
                            <div class="image-upload">
                                <img src="views/assets/images/upload.svg" alt="Upload Icon" >
                                <p>Drag and drop a file to upload</p>
                                <input type="file" class="form-control d-none" id="image" name="image">
                                <div id="image-preview"></div>
                            </div>
                            <input type="text" class="form-control mt-2" id="imageUrl" placeholder="Enter Image URL">
                        </div>

                        <div class="col-md-12 d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="/products" class="btn btn-secondary">Cancel</a>
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
    