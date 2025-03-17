<form action="/stock/store" method="POST" style="background-color: #f9f9f9; padding: 40px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 700px; width: 100%; margin: auto; position: absolute; top: 30%; left: 50%; transform: translate(-50%, -30%);">
    <div class="form-group">
        <label for="stock_id" style="font-size: 18px;">Stock ID</label>
        <input type="text" id="stock_id" name="stock_id" class="form-control" required placeholder="Enter Stock ID" style="width: 100%; padding: 12px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc;">
    </div>
    <div class="form-group">
        <label for="stock_name" style="font-size: 18px;" class="mt-4">Stock Name</label>
        <input type="text" id="stock_name" name="stock_name" class="form-control" required placeholder="Enter Stock Name" style="width: 100%; padding: 12px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc;">
    </div>
    <!-- Wrap the button in a flex container to push it to the right -->
    <div class="d-flex justify-content-end mt-4">
        <button type="submit" class="btn btn-primary" style="background-color: #007bff; color: white; padding: 10px 20px; font-size: 18px; border: none; border-radius: 4px; cursor: pointer;">Submit</button>
    </div>
</form>

