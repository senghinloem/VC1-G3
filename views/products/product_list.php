<main class="app-main mt-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Product List</h2>
            <a href="/product_list/create_list" class="btn btn-success px-4 py-2 shadow">+ Add Product</a>
        </div>

        <!-- Search Bar -->
        <form action="/product_list/search" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="name" class="form-control rounded-start" placeholder="Search by name">
                <button type="submit" class="btn btn-primary px-4">Search</button>
            </div>
        </form>

        <div class="table-container p-3">
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead class="table-header">
                        <tr>
                            <th class="text-center">Image</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Available</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($product_list) && is_array($product_list)): ?>
                            <?php foreach ($product_list as $list): ?>
                                <tr>
                                    <td class="text-center">
                                        <img src="<?= $list['image'] ?>" alt="Product Image" class="product-img">
                                    </td>
                                    <td class="text-center"><?= $list['name'] ?></td>
                                    <td class="text-center"><?= $list['available_quantity'] ?></td>
                                    <td class="text-center">$<?= number_format($list['price'], 2) ?></td>
                                    <td class="text-center">
                                        <a href="/product_list/detail/<?= $list['product_list_id']?>" class="btn btn-outline-info btn-sm"><i class="fas fa-eye"></i></a>
                                        <a href="/product_list/edit/<?= $list['product_list_id']?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i></a>
                                        <form action="/product_list/destroy/<?= $list['product_list_id']?>" method="POST" class="d-inline">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                    
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">No products available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Enhanced CSS -->
<style>
    /* General Styling */
    body {
        background-color: #f8f9fa;
    }

    .app-main {
        padding: 20px;
    }

    /* Table Card */
    .table-container {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    /* Table Styling */
    .custom-table {
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
    }

    .table-header {
        background: #343a40;
        color: #fff;
    }

    /* Image Styling */
    .product-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-img:hover {
        transform: scale(1.1);
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Buttons */
    .btn-sm {
        font-size: 14px;
        padding: 6px 12px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-outline-info:hover, 
    .btn-outline-primary:hover, 
    .btn-outline-danger:hover {
        color: #fff;
        transform: scale(1.05);
    }

    .btn-sm i {
        transition: color 0.3s ease;
    }

    .btn-outline-info:hover i, 
    .btn-outline-primary:hover i, 
    .btn-outline-danger:hover i {
        color: #fff !important;
    }

    /* Search Bar */
    .input-group input {
        border-right: none;
    }

    .input-group .btn {
        border-left: none;
    }
</style>
