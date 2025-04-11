<form action="/stock/update/<?= $stock['stock_id'] ?>" method="POST"
    style="background-color: #f9f9f9; padding: 40px; border-radius: 8px; 
           box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 700px; 
           width: 100%; margin: auto; position: absolute; top: 30%; 
           left: 50%; transform: translate(-50%, -30%);">

    <div class="form-group">
        <label for="stock_name" style="font-size: 18px;">Stock Name</label>
        <input type="text" id="stock_name" name="stock_name" class="form-control"
            value="<?= htmlspecialchars($stock['stock_name']) ?>" required
            style="width: 100%; padding: 12px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc;">
    </div>

    <div class="form-group mt-4">
        <label for="product" style="font-size: 18px;">Product</label>
        <input type="text" id="product" name="product" class="form-control"
            value="<?= htmlspecialchars($stock['product']) ?>" required min="0" max="500"
            style="width: 100%; padding: 12px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc;">
    </div>

    <div class="form-group mt-4">
        <label for="quantity" style="font-size: 18px;">Quantity Product</label>
        <input type="number" id="quantity" name="quantity" class="form-control"
            value="<?= htmlspecialchars($stock['quantity']) ?>" required min="0" max="500"
            style="width: 100%; padding: 12px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc;">
    </div>

    <input type="hidden" id="status" name="status" value="<?= htmlspecialchars($stock['status'] ?? '') ?>">

    <div style="text-align: right;">
        <a href="/stock" class="btn btn-secondary mt-4 px-4 py-2 fs-5" style="border-radius: 4px;">Cancel</a>
        <button type="submit" class="btn btn-primary mt-4 px-4 py-2 fs-5" style="border-radius: 4px;" onclick="setStatus()">Update</button>
    </div>
</form>

<script>
    function setStatus() {
        const quantity = document.getElementById('quantity').value;
        const statusField = document.getElementById('status');
        if (quantity > 500) {
            quantity = 500; 
            quantityInput.value = 500; 
            alert('Maximum stock limit is 100. Quantity has been adjusted.');
        }
        statusField.value = quantity > 0 ? 'in_stock' : 'out_of_stock';
        console.log('Status set to:', statusField.value); 
    }
</script>