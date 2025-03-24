
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stock Inventory</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .table thead th {
      background-color: #f8f9fa;
    }

    .btn-success,
    .btn-danger {
      border-radius: 4px;
    }
  </style>
</head>

<body>
  <div class="container mt-5">
    <div class="card">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-bordered mb-0">
            <thead class="bg-light">
              <tr>
                <th class="text-center">Id</th>
                <th class="text-center">Items</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($stock_management)): ?>
                <?php foreach ($stock_management as $item): ?>
                  <tr>
                    <td class="text-center"><?= htmlspecialchars($item['product_id']) ?></td>
                    <td class="text-center"><?= htmlspecialchars($item['items']) ?></td>
                    <td class="text-center"><?= htmlspecialchars($item['quantity']) ?></td>
                    <td class="text-center">
                      <!-- <div class="d-flex justify-content-center gap-2">
                        <a href="/stock/view/<?= htmlspecialchars($item['product_id']) ?>" class="btn btn-primary">View</a>
                        <a href="/stock/edit/<?= htmlspecialchars($item['product_id']) ?>" class="btn btn-warning">Edit</a>
                        <a href="/stock/destroy/<?= htmlspecialchars($item['product_id']) ?>" class="btn btn-danger">Delete</a>
                      </div> -->
                      <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-success" style="width: 40px; height: 40px; padding: 0;">
                          <span style="font-size: 20px; line-height: 1;">+</span>
                        </button>
                        <button class="btn btn-danger" style="width: 40px; height: 40px; padding: 0;">
                          <span style="font-size: 20px; line-height: 1;">-</span>
                        </button>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4" class="text-center">No products available.</td>
                </tr>
              <?php endif; ?>
            </tbody>
            <!-- <tbody>
              <tr>
                <td class="text-center">1</td>
                <td class="text-center">Plastic plate</td>
                <td class="text-center">100</td>
                <td class="text-center">
                  <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-success" style="width: 40px; height: 40px; padding: 0;">
                      <span style="font-size: 20px; line-height: 1;">+</span>
                    </button>
                    <button class="btn btn-danger" style="width: 40px; height: 40px; padding: 0;">
                      <span style="font-size: 20px; line-height: 1;">-</span>
                    </button>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="text-center">2</td>
                <td class="text-center">Plastic plate</td>
                <td class="text-center">100</td>
                <td class="text-center">
                  <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-success" style="width: 40px; height: 40px; padding: 0;">
                      <span style="font-size: 20px; line-height: 1;">+</span>
                    </button>
                    <button class="btn btn-danger" style="width: 40px; height: 40px; padding: 0;">
                      <span style="font-size: 20px; line-height: 1;">-</span>
                    </button>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="text-center">3</td>
                <td class="text-center">Plastic plate</td>
                <td class="text-center">100</td>
                <td class="text-center">
                  <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-success" style="width: 40px; height: 40px; padding: 0;">
                      <span style="font-size: 20px; line-height: 1;">+</span>
                    </button>
                    <button class="btn btn-danger" style="width: 40px; height: 40px; padding: 0;">
                      <span style="font-size: 20px; line-height: 1;">-</span>
                    </button>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="text-center">4</td>
                <td class="text-center">Plastic plate</td>
                <td class="text-center">100</td>
                <td class="text-center">
                  <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-success" style="width: 40px; height: 40px; padding: 0;">
                      <span style="font-size: 20px; line-height: 1;">+</span>
                    </button>
                    <button class="btn btn-danger" style="width: 40px; height: 40px; padding: 0;">
                      <span style="font-size: 20px; line-height: 1;">-</span>
                    </button>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="text-center">5</td>
                <td class="text-center">Plastic plate</td>
                <td class="text-center">100</td>
                <td class="text-center">
                  <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-success" style="width: 40px; height: 40px; padding: 0;">
                      <span style="font-size: 20px; line-height: 1;">+</span>
                    </button>
                    <button class="btn btn-danger" style="width: 40px; height: 40px; padding: 0;">
                      <span style="font-size: 20px; line-height: 1;">-</span>
                    </button>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="text-center">6</td>
                <td class="text-center">Plastic plate</td>
                <td class="text-center">100</td>
                <td class="text-center">
                  <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-success" style="width: 40px; height: 40px; padding: 0;">
                      <span style="font-size: 20px; line-height: 1;">+</span>
                    </button>
                    <button class="btn btn-danger" style="width: 40px; height: 40px; padding: 0;">
                      <span style="font-size: 20px; line-height: 1;">-</span>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody> -->
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

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


