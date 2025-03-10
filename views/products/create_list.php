
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