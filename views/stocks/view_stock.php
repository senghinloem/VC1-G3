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
                        <?php if (isset($stock_management) && !empty($stock_management)): ?>
                            <?php foreach ($stock_management as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['stock_id']) ?></td>
                                    <td><?= htmlspecialchars($item['stock_name']) ?></td>
                                    <td>
                                        <a href="/stock/view/<?= htmlspecialchars($item['stock_id']) ?>" class="btn-sm">View</a>
                                        <a href="/stock/create" class="btn btn-success btn-sm ms-3">Add</a>
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
