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

        .error-text {
            color: red;
            font-size: 14px;
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
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>">
                            <small class="error-text"><?= $errors['name'] ?? '' ?></small>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Product Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="0" value="<?= htmlspecialchars($old['quantity'] ?? '') ?>">
                            <small class="error-text"><?= $errors['quantity'] ?? '' ?></small>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description" value="<?= htmlspecialchars($old['description'] ?? '') ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Product Price</label>
                            <input type="number" class="form-control" id="price" name="price" min="0.01" step="0.01" value="<?= htmlspecialchars($old['price'] ?? '') ?>">
                            <small class="error-text"><?= $errors['price'] ?? '' ?></small>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Unit</label>
                            <select class="form-select" id="unit" name="unit">
                                <option value="pcs" <?= isset($old['unit']) && $old['unit'] == 'pcs' ? 'selected' : '' ?>>Pieces (pcs)</option>
                                <option value="kg" <?= isset($old['unit']) && $old['unit'] == 'kg' ? 'selected' : '' ?>>Kilograms (kg)</option>
                                <option value="L" <?= isset($old['unit']) && $old['unit'] == 'L' ? 'selected' : '' ?>>Liters (L)</option>
                                <option value="m" <?= isset($old['unit']) && $old['unit'] == 'm' ? 'selected' : '' ?>>Meters (m)</option>
                                <option value="box" <?= isset($old['unit']) && $old['unit'] == 'box' ? 'selected' : '' ?>>Boxes</option>
                                <option value="pack" <?= isset($old['unit']) && $old['unit'] == 'pack' ? 'selected' : '' ?>>Packs</option>
                                <option value="carton" <?= isset($old['unit']) && $old['unit'] == 'carton' ? 'selected' : '' ?>>Cartons</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Product Image</label>
                            <p class="text-warning">(should white background)</p> 
                            <div class="image-upload">
                                <img src="views/assets/images/upload.svg" alt="Upload Icon">
                                <p>Drag and drop a file to upload or click</p>
                                <input type="file" class="form-control d-none" id="image" name="image" accept="image/*">
                                <div id="image-preview"></div>
                            </div>
                            <input type="text" class="form-control mt-2" id="imageUrl" name="image_url" placeholder="Enter Image URL" value="<?= htmlspecialchars($old['image_url'] ?? '') ?>">
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
        const imageInput = document.querySelector('#image');
        const imageUrlInput = document.querySelector('#imageUrl');
        const imageUpload = document.querySelector('.image-upload');
        const previewContainer = document.getElementById('image-preview');
        const preview = document.createElement('img');
        preview.style.maxWidth = '200px';

        const uploadIcon = imageUpload.querySelector('img');
        const uploadText = imageUpload.querySelector('p');

        // Function to show or hide default UI elements
        function updateUploadUI(showPreview) {
            if (showPreview) {
                uploadIcon.style.display = 'none';
                uploadText.style.display = 'none';
            } else {
                uploadIcon.style.display = 'block';
                uploadText.style.display = 'block';
                previewContainer.innerHTML = '';  // Remove preview
            }
        }

        // File Upload Preview
        imageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    previewContainer.innerHTML = '';
                    previewContainer.appendChild(preview);
                    updateUploadUI(true);
                };
                reader.readAsDataURL(file);

                // Reset the URL input and enable it again
                imageUrlInput.value = '';
                imageUrlInput.disabled = false;
            } else {
                updateUploadUI(false);
            }
        });

        // URL Input Preview
        imageUrlInput.addEventListener('input', function () {
            if (this.value.trim()) {
                preview.src = this.value.trim();
                previewContainer.innerHTML = '';
                previewContainer.appendChild(preview);
                updateUploadUI(true);

                // Disable file input since a URL is provided
                imageInput.value = '';
                imageInput.disabled = true;
            } else {
                // If URL is cleared, enable file input again
                imageInput.disabled = false;
                updateUploadUI(false);
            }
        });

        // Click on upload area to trigger file selection
        imageUpload.addEventListener('click', function () {
            imageInput.click();
        });


        

        // document.querySelector('.image-upload').addEventListener('click', function() {
        //     this.querySelector('input[type=file]').click();
        // });
    </script>
