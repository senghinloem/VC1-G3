<?php require 'views/layouts/header.php'; ?>
<div class="container mt-5">
    <h2>Stock Management Form</h2>
    <form action="/stock/update?id=<?=$stock['id']?> " method="POST" enctype="multipart/form-data">
    <!-- <form action="/user/update?id=<?= $user['id'] ?>" method="POST" enctype="multipart/form-data"> -->
        <div class="form-group">
            <label for="stockId">Stock ID:</label>
            <input type="text" class="form-control" id="stockId" name="stockId" value="<?php echo $stock['stockId']; ?>" required>
        </div>
        <div class="form-group">
            <label for="stockName">Stock Name:</label>
            <input type="text" class="form-control" id="stockName" name="stockName" value="<?php echo $stock['stockName']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<?php require 'views/layouts/footer.php'; ?>
