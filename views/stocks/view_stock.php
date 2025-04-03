<div class="container mt-4">
    <div class="card mt-2">
        <div class="card-header bg-white p-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h4 class="mb-0 d-flex align-items-center">
                    <i class="fas fa-boxes me-2 text-primary"></i> Stock Items
                </h4>
                <div class="d-flex flex-wrap gap-3">
                    <div class="search-container">
                        <form action="/stock/search" method="GET" class="d-flex align-items-center" id="searchForm">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control border-start-0" placeholder="Search stock..." value="" id="searchInput">
                            </div>
                        </form>
                    </div>
                    <a href="/stock/create" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create Stock
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-5">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="fas fa-box me-2"></i> Items List
            </h4>
        </div>
        <div class="card-body">
            <!-- Display success message if present -->
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
            <?php endif; ?>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Items</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Sample data (replace with your actual data from the database)
                    $stocks = [
                        ['id' => 1, 'item' => 'Plastic plate', 'quantity' => 100],
                        ['id' => 2, 'item' => 'Plastic plate', 'quantity' => 100],
                        ['id' => 3, 'item' => 'Plastic plate', 'quantity' => 100],
                        ['id' => 4, 'item' => 'Plastic plate', 'quantity' => 100],
                        ['id' => 5, 'item' => 'Plastic plate', 'quantity' => 100],
                        ['id' => 6, 'item' => 'Plastic plate', 'quantity' => 100],
                    ];

                    foreach ($stocks as $stock): ?>
                        <tr>
                            <td><?= htmlspecialchars($stock['id']) ?></td>
                            <td><?= htmlspecialchars($stock['item']) ?></td>
                            <td><?= htmlspecialchars($stock['quantity']) ?></td>
                            <td>
                                <!-- View Button (Green "+") -->
                                <a href="/stock/view/<?=$stock['id']?>" class="btn btn-success btn-sm">
                                    <i class="fas fa-plus"></i>
                                </a>
                                <!-- Delete Button (Red "−") -->
                                <a href="/stock/delete/<?= $stock['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">
                                    <i class="fas fa-minus"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>