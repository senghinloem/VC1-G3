<form action="/stock/view_stock" method="GET" style="background-color: #f9f9f9; padding: 40px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 700px; width: 100%; margin: auto; position: absolute; top: 30%; left: 50%; transform: translate(-50%, -30%);">
    <div class="form-group">
        <label for="stock_id" style="font-size: 18px;">Stock ID</label>
        <input type="text" id="stock_id" name="stock_id" class="form-control" required placeholder="Enter Stock ID" style="width: 100%; padding: 12px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc;">
    </div>
    <div class="form-group">
        <label for="stock_name" style="font-size: 18px;" class="mt-4">Items</label>
        <input type="text" id="stock_name" name="stock_name" class="form-control" required placeholder="Enter Stock Name" style="width: 100%; padding: 12px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc;">
    </div>

    <div class="form-group">
        <label for="quantity" style="font-size: 18px;" class="mt-4">Quantity</label>
        <input type="text" id="quantity" name="quantity" class="form-control" required placeholder="Enter Quantity" style="width: 100%; padding: 12px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc;">
    </div>

    <button type="submit" class="btn btn-primary" style="background-color: #007bff; color: white; padding: 10px 20px; font-size: 18px; border: none; border-radius: 4px; cursor: pointer;">Submit</button>
</form>

