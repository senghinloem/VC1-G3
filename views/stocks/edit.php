<form action="/stock/update/<?= $stock['stock_id'] ?>" method="POST" 
      style="background-color: #f9f9f9; padding: 40px; border-radius: 8px; 
             box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); max-width: 700px; 
             width: 100%; margin: auto; position: absolute; top: 30%; 
             left: 50%; transform: translate(-50%, -30%);">
    
    <!-- Hidden input for stock_id -->
    <input type="hidden" name="stock_id" value="<?= $stock['stock_id'] ?>">

    <div class="form-group">
        <label for="stock_name" style="font-size: 18px;">Stock Name</label>
        <input type="text" id="stock_name" name="stock_name" class="form-control" 
               value="<?= $stock['stock_name'] ?>" required 
               style="width: 100%; padding: 12px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc;">
    </div>

    <div style="text-align: right;">
        <button type="submit" class="btn btn-primary mt-4" 
                style="background-color: #007bff; color: white; padding: 10px 20px; font-size: 18px; 
                       border: none; border-radius: 4px; cursor: pointer; width: auto;">Update</button>
    </div>
</form>

