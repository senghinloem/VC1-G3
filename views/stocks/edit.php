<?php
if (!isset($stock)) {
    $stock = ['stock_id' => '', 'stock_name' => '', 'product_id' => '', 'quantity' => 0, 'status' => 'out_of_stock'];
}
if (!isset($products)) {
    $products = [];
}

// Find the selected product
$selected_product = null;
foreach ($products as $product) {
    if ($product['product_id'] == $stock['product_id']) {
        $selected_product = $product;
        break;
    }
}
?>

<div class="container mt-5">
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <form class="mt-5" action="/stock/update/<?= htmlspecialchars($stock['stock_id']) ?>" method="POST"
        style="background-color: #f9f9f9; padding: 40px; border-radius: 8px; 
               box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 700px; 
               width: 100%; margin: auto;">
        
        <div class="form-group">
            <label for="stock_name" style="font-size: 18px;">Stock Name</label>
            <input type="text" id="stock_name" name="stock_name" class="form-control"
                value="<?= htmlspecialchars($stock['stock_name']) ?>" required
                style="width: 100%; padding: 12px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc;">
        </div>

        <div class="form-group mt-4">
            <label for="product_name" style="font-size: 18px;">Product</label>
            <input type="text" id="product_name" class="form-control"
                value="<?= htmlspecialchars($selected_product['name'] ?? '') ?>" readonly
                style="width: 100%; padding: 12px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc; background-color: #e9ecef;">
            <input type="hidden" id="product_id" name="product_id" value="<?= htmlspecialchars($stock['product_id']) ?>">
        </div>

        <div class="form-group mt-4">
            <label for="quantity" style="font-size: 18px;">Quantity</label>
            <input type="number" id="quantity" name="quantity" class="form-control"
                value="<?= htmlspecialchars($stock['quantity']) ?>" required min="0" max="500"
                style="width: 100%; padding: 12px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc;">
        </div>

        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" id="status" name="status" value="<?= htmlspecialchars($stock['status']) ?>">

        <div style="text-align: right;">
            <a href="/stock" class="btn btn-secondary mt-4 px-4 py-2 fs-5" style="border-radius: 4px;">Cancel</a>
            <button type="submit" class="btn btn-primary mt-4 px-4 py-2 fs-5" style="border-radius: 4px;">Update</button>
        </div>
    </form>
</div>

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