<form action="/stock/update/<?= $stock['stock_id'] ?>" method="POST">
    <label for="stock_name">Stock Name</label>
    <input type="text" id="stock_name" name="stock_name" class="form-control" value="<?= $stock['stock_name'] ?>" required>
    <button type="submit" class="btn btn-primary">Update Stock</button>
</form>
