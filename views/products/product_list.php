<main class="app-main mt-3">
    <div class="container">
        <h2>Product List</h2>
        <a href="/product_list/create_list" class="btn btn-primary mb-2">+ Add Product</a>
        <table class="table custom-table">
            <thead>
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Available</th>
                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($product_list) && is_array($product_list) && !empty($product_list)) {
                    foreach ($product_list as $list):
                ?>
                        <tr>
                            <td><img src="<?= $list['image'] ?>" alt="Product Image" width="100"></td>
                            <td><?= $list['available_quantity'] ?></td>
                            <td><?= $list['price'] ?></td>
                            <td>
                                <a href="/product_list/delete/<?= $list['product_list_id']?>" class="btn btn-danger">Delete</a>
                                <a href="/product_list/edit/<?= $list['product_list_id']?>" class="btn btn-primary">Edit</a>
                            </td>
                        </tr>
                <?php
                    endforeach;
                } else {
                    echo "<tr><td colspan='4'>No products available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<!-- In your CSS file or within a <style> block -->
<style>
    .custom-table {
        background-color: #f8f9fa; /* Light background color */
        color: #343a40; /* Dark text color for contrast */
    }
</style>
