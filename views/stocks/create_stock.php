<form action="/stock/store" method="POST" style="background-color: #f9f9f9; padding: 40px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 700px; width: 100%; margin: auto; position: absolute; top: 30%; left: 50%; transform: translate(-50%, -30%);">
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <div class="form-group">
        <label for="stock_name" style="font-size: 18px;" class="mt-4">Stock Name</label>
        <input type="text" id="stock_name" name="stock_name" class="form-control" required 
               placeholder="Enter Stock Name" style="width: 100%; padding: 12px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc;">
    </div>

    <div class="form-group">
        <label for="stock_name" style="font-size: 18px;" class="mt-4">Product Name</label>
        <input type="text" id="stock_name" name="stock_name" class="form-control" required 
               placeholder="Enter Product Name" style="width: 100%; padding: 12px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc;">
    </div>
    
    <div class="form-group">
        <label for="quantity" style="font-size: 18px;" class="mt-4">Quantity</label>
        <input type="number" id="quantity" name="quantity" class="form-control" required 
               placeholder="Enter Quantity" min="0" style="width: 100%; padding: 12px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc;">
    </div>
    
    <input type="hidden" id="status" name="status" value="in_stock">
    
    <div class="d-flex justify-content-end mt-4 gap-2">
        <a href="/stock" class="btn btn-secondary btn-lg">Cancel</a>
        <button type="submit" class="btn btn-primary btn-lg" onclick="setStatus()">Submit</button>
    </div>
</form>

<script>
    function setStatus() {
        const quantity = document.getElementById('quantity').value;
        const statusField = document.getElementById('status');
        statusField.value = quantity > 0 ? 'in_stock' : 'out_of_stock';
    }
</script>