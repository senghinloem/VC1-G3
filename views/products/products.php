
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="input-group w-50">
                <input type="text" class="form-control" placeholder="Search for product...">
                <button class="btn btn-outline-secondary" type="button">
                    <i class="bi bi-search"></i>
                </button>
            </div>
            <div>
                <!-- <button class="btn btn-primary">+ Add Product</button> -->
                 <a href="/create" class="btn btn-primary">Add Product</a>
                <a href="" class="btn btn-dark" class="file-upload">Import Products</a>
            </div>
        </div>
        
        <h4>Products</h4>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">Poduct Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Add to stock</th>
                    <th scope="col">Delete from table</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products) && is_array($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" width="10"></td>
                            <td><?= htmlspecialchars($product['name']) ?></td>
                            <td><?= htmlspecialchars($product['description']) ?></td>
                            <td><?= htmlspecialchars($product['price']) ?></td>
                            <td><?= htmlspecialchars($product['unit']) ?></td>
                            <td><?= htmlspecialchars($product['stock']) ?></td>
                            <td>
                                <a href="" class="btn btn-primary">ADD</a>
                            </td>
                            <td>
                                <a href="" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">There Is No products.</td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </div>
        
        <button class="btn btn-dark mt-3 mb-3">Add to Stock</button>
    </div>
