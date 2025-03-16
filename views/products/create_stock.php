<div class="container">
    <h2>Create New Stock</h2>
    <form action="/stock/store" method="POST">
        <div class="mb-3">
            <label for="stock_name" class="form-label">Stock Name</label>
            <input type="text" class="form-control" id="stock_name" name="stock_name" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
