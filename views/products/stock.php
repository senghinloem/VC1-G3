<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="input-group w-50">
            <input type="text" class="form-control" placeholder="Search for product...">
            <button class="btn btn-outline-secondary" type="button">
                <i class="bi bi-search success"></i>
            </button>
        </div>
    </div>
    <!-- Product in stock -->
    <h4 class="text-primary">Product in stock</h4>
    <div class="row g-3">
        <div class="col-md-12">
            <div class="table-responsive" style="height: calc(100vh - 150px); overflow-y: auto;">
                <table class="table table-bordered table-hover">
                    <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Stock Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($stock_management)): ?>
                            <?php foreach ($stock_management as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['stock_id'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($item['stock_name'] ?? 'Unnamed Product') ?></td>
                                    <td>
                                        <span class="">View Detail</span>
                                        <a href="/stock/add/<?= $item['stock_id'] ?? '#' ?>" class="ms-5 btn btn-success btn-sm">ADD</a>
                                        <a href="/stock/edit/<?= $item['stock_id'] ?? '#' ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="/stock/destroy/<?= $item['stock_id'] ?? '#' ?>" class="btn btn-danger btn-sm">Delete</a>
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
    <!-- Product out of stock -->
    <h4 class="text-danger">Product out of stock</h4>
    <div class="row g-3">
        <div class="col-md-12">
            <div class="table-responsive" style="height: calc(100vh - 150px); overflow-y: auto;">
                <table class="table table-bordered table-hover">
                    <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Stock Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($stock_management)): ?>
                            <?php foreach ($stock_management as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['stock_id'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($item['stock_name'] ?? 'Unnamed Product') ?></td>
                                    <td>
                                        <span class="">View Detail</span>
                                        <a href="/stock/add/<?= $item['stock_id'] ?? '#' ?>" class="ms-5 btn btn-success btn-sm">ADD</a>
                                        <a href="/stock/edit/<?= $item['stock_id'] ?? '#' ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="/stock/destroy/<?= $item['stock_id'] ?? '#' ?>" class="btn btn-danger btn-sm">Delete</a>
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