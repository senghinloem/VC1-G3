<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="input-group w-50">
            <input type="text" class="form-control" placeholder="Search for product...">
            <button class="btn btn-outline-secondary" type="button">
                <i class="bi bi-search success"></i>
            </button>
        </div>
        <a href="/stock/create" class="btn btn-primary">Add Product</a>
    </div>

    <div class="row g-3 mt-5">
        <!-- Product in stock -->
        <div class="col-md-6">
            <h4 class="text-primary">Stock has product</h4>
            <div class="table-responsive" style="height: calc(100vh - 150px); overflow-y: auto;">
                <table class="table table-bordered table-hover mt-4">
                    <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                        <tr>
                            <th>Id</th>
                            <th>Stock Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($stock_management)): ?>
                            <?php foreach ($stock_management as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['stock_id']) ?></td>
                                    <td><?= htmlspecialchars($item['stock_name']) ?></td>
                                    <td>
                                        <a href="/stock/view/<?= htmlspecialchars($item['stock_id']) ?>" class=" btn-sm">View</a>
                                        <!-- <a href="/stock/create<?= htmlspecialchars($item['stock_id']) ?>" class="btn btn-success btn-sm ms-3">Add</a> -->
                                        <a href="/stock/create" <?= htmlspecialchars($item['stock_id']) ?> class="btn btn-success btn-sm ms-3">Add</a>
                                        <a href="/stock/edit/<?= htmlspecialchars($item['stock_id']) ?>" class="btn btn-warning btn-sm ms-3">Edit</a>
                                        <a href="/stock/destroy/<?= htmlspecialchars($item['stock_id']) ?>" class="btn btn-danger btn-sm ms-3">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">No products available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Product out of stock -->
        <div class="col-md-6">
            <h4 class="text-danger">Stock has no product</h4>
            <div class="table-responsive" style="height: calc(100vh - 150px); overflow-y: auto;">
                <table class="table table-bordered table-hover mt-4">
                    <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                        <tr>
                            <th>Id</th>
                            <th>Stock Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($stock_management)): ?>
                            <?php foreach ($stock_management as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['stock_id']) ?></td>
                                    <td><?= htmlspecialchars($item['stock_name']) ?></td>
                                    <td>
                                        <a href="/stock/view/<?= htmlspecialchars($item['stock_id']) ?>" class=" btn-sm">View</a>
                                        <a href="/stock/create" <?= htmlspecialchars($item['stock_id']) ?> class="btn btn-success btn-sm ms-3">Add</a>
                                        <a href="/stock/edit/<?= htmlspecialchars($item['stock_id']) ?>" class="btn btn-warning btn-sm ms-3">Edit</a>
                                        <a href="/stock/destroy/<?= htmlspecialchars($item['stock_id']) ?>" class="btn btn-danger btn-sm ms-3">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">No products available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


//view_stock.php
<!-- <form action="/stock/view_stock" method="GET" style="background-color: #f9f9f9; padding: 40px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 700px; width: 100%; margin: auto; position: absolute; top: 30%; left: 50%; transform: translate(-50%, -30%);">
    <div class="form-group">
        <label for="stock_id" style="font-size: 18px;">Stock ID</label>
        <input type="text" id="stock_id" name="stock_id" class="form-control" required placeholder="Enter Stock ID" style="width: 100%; padding: 12px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc;">
    </div>
    <div class="form-group">
        <label for="stock_name" style="font-size: 18px;" class="mt-4">Items</label>
        <input type="text" id="stock_name" name="stock_name" class="form-control" required placeholder="Enter Stock Name" style="width: 100%; padding: 12px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc;">
    </div>

    <div class="form-group">
        <label for="quantity" style="font-size: 18px;" class="mt-4">Quantity</label>
        <input type="text" id="quantity" name="quantity" class="form-control" required placeholder="Enter Quantity" style="width: 100%; padding: 12px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc;">
    </div>

    <button type="submit" class="btn btn-primary" style="background-color: #007bff; color: white; padding: 10px 20px; font-size: 18px; border: none; border-radius: 4px; cursor: pointer;">Submit</button>
</form> -->