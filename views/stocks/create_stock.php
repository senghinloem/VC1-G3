<?php
if (!isset($products)) {
    $products = [];
}
?>

<div class="container mt-3">
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form class="mt-5" action="/stock/store" method="POST"
        style="background-color: #f9f9f9; padding: 40px; border-radius: 8px; 
               box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 700px; 
               width: 100%; margin: auto;">

        <div class="form-group">
            <label for="stock_name" style="font-size: 18px;">Stock Name</label>
            <input type="text" id="stock_name" name="stock_name" class="form-control"
                value="" required
                style="width: 100%; padding: 12px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc;">
        </div>
        <div class="form-group mt-4">
            <label for="product_id" style="font-size: 18px;">Product</label>
            <select id="product_id" name="product_id" class="form-control" required
                style="width: 100%; padding: 12px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc;">
                <option value="">Select a product</option>
                <?php foreach ($products as $product): ?>
                    <option value="<?= htmlspecialchars($product['product_id']) ?>">
                        <?= htmlspecialchars($product['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group mt-4">
            <label for="quantity" style="font-size: 18px;">Quantity</label>
            <input type="number" id="quantity" name="quantity" class="form-control"
                value="0" required min="0" max="500"
                style="width: 100%; padding: 12px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc;">
        </div>

        <input type="hidden" id="status" name="status" value="in_stock">

        <div style="text-align: right;">
            <a href="/stock" class="btn btn-secondary mt-4 px-4 py-2 fs-5" style="border-radius: 4px;">Cancel</a>
            <button type="submit" class="btn btn-primary mt-4 px-4 py-2 fs-5" style="border-radius: 4px;">Create</button>
        </div>
    </form>
</div>
</form>
<script>
    document.getElementById('quantity').addEventListener('change', function() {
        const quantity = parseInt(this.value);
        const statusField = document.getElementById('status');

        if (quantity > 500) {
            this.value = 500;
            alert('Maximum stock limit is 500. Quantity has been adjusted.');
        }

        statusField.value = quantity > 0 ? 'in_stock' : 'out_of_stock';
    });
</script>