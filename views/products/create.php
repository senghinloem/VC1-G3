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
            transition: border-color 0.3s, background-color 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 150px; 
            position: relative;
            background-color: #f9f9f9;
            width: 100%;
            margin-bottom: 10px;
        }
        .image-upload:hover {
            border-color: #007bff;
            background-color: #e9f0ff;
        }

        .image-upload .upload-icon {
            width: 50px;
            height: 50px;
            margin-bottom: 10px;
        }

        .image-upload p.upload-text {
            margin: 0;
            font-size: 14px;
            color: #555;
            font-weight: 500;
        }

        .image-upload img.preview {
            max-width: 100%;
            max-height: 160px;
            object-fit: contain;
            border-radius: 10px;
            border: 2px solid #007bff;
            padding: 8px;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .image-upload img.preview:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
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
                        
                        <div class="col-md-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" id="category_id" name="category_id">
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= htmlspecialchars($category['category_id']) ?>"
                                        <?= isset($old['category_id']) && $old['category_id'] == $category['category_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category['category_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                <small class="error-text"><?= $errors['category_id'] ?? '' ?></small>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Product Image</label>
                            <p class="text-warning">(should white background)</p> 
                            <div class="image-upload">
                                <svg class="upload-icon" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="#f0ad4e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="17 8 12 3 7 8"></polyline>
                                    <line x1="12" y1="3" x2="12" y2="15"></line>
                                </svg>
                                <p class="upload-text">Drag and drop a file to upload or click</p>
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
    preview.classList.add('preview'); // Add the preview class for styling

    const uploadIcon = imageUpload.querySelector('.upload-icon');
    const uploadText = imageUpload.querySelector('.upload-text');

    // Function to show or hide default UI elements
    function updateUploadUI(showPreview) {
        if (showPreview) {
            uploadIcon.style.display = 'none';
            uploadText.style.display = 'none';
            previewContainer.style.display = 'block';
        } else {
            uploadIcon.style.display = 'block';
            uploadText.style.display = 'block';
            previewContainer.style.display = 'none';
            previewContainer.innerHTML = '';  // Remove preview
        }
    }

    // Initialize UI on page load
    updateUploadUI(false);

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

    // Check if there's an image URL on page load (e.g., after failed submission)
    // window.addEventListener('load', function () {
    //     if (imageUrlInput.value.trim()) {
    //         preview.src = imageUrlInput.value.trim();
    //         previewContainer.innerHTML = '';
    //         previewContainer.appendChild(preview);
    //         updateUploadUI(true);
    //     } else {
    //         updateUploadUI(false);
    //     }
    // });

    window.addEventListener('load', function () {
        setTimeout(() => {
            // Check if there's an image URL from a previous submission
            if (imageUrlInput.value.trim()) {
                // Validate if the URL is a valid image by attempting to load it
                const img = new Image();
                img.onload = function () {
                    preview.src = imageUrlInput.value.trim();
                    previewContainer.innerHTML = '';
                    previewContainer.appendChild(preview);
                    updateUploadUI(true); // Show preview, hide icon/text
                };
                img.onerror = function () {
                    updateUploadUI(false); // If the URL is invalid, show the upload icon/text
                };
                img.src = imageUrlInput.value.trim();
            } else {
                updateUploadUI(false); // No image URL, show the upload icon/text
            }
        }, 100); // Slight delay to ensure DOM is fully rendered
    });
</script>
