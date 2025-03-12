<main class="app-main mt-3">
    <div class="container">
        <h2 class="mb-4">Product List</h2>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="/product_list/create_list" class="btn btn-success px-4 py-2 shadow-sm">+ Add Product</a>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered table-hover custom-table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="text-center">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col" class="text-center">Available</th>
                        <th scope="col" class="text-center">Price</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($product_list) && is_array($product_list)): ?>
                        <?php foreach ($product_list as $list): ?>
                            <tr>
                                <td class="text-center">
                                    <img src="<?= $list['image'] ?>" alt="Product Image" class="product-img">
                                </td>
                                <td><?= $list['name']?></td>
                                <td class="text-center"><?= $list['available_quantity'] ?></td>
                                <td class="text-center">$<?= number_format($list['price'], 2) ?></td>
                                <td class="text-center">
                                    <a href="" class="btn btn-outline-info btn-sm"><i class="fas fa-eye"></i></a>
                                    <a href="/product_list/edit/<?= $list['product_list_id']?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i></a>
                                    <form action="/product_list/destroy/<?= $list['product_list_id']?>" method="POST" style="display:inline;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">No products available</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Improved CSS -->
<style>
    .custom-table {
        background-color: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .thead-dark {
        background-color: #343a40;
        color: #fff;
    }

    .product-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .product-img:hover {
        transform: scale(1.1);
    }

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

</style>


