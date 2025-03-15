<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            border-radius: 10px;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .selection {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 1rem;
        }

        .selection .form-select {
            width: auto;
            min-width: 150px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h2>Dashboard</h2>

        <div class="row text-center mb-4">
            <div class="col-md-3"><span class="text-danger stat-number">+200</span><br>Total Products</div>
            <div class="col-md-3"><span class="text-primary stat-number">+27</span><br>Out of Stock</div>
            <div class="col-md-3"><span class="text-danger stat-number">+08</span><br>Total Supplier</div>
            <div class="col-md-3"><span class="text-primary stat-number">-27</span><br>Total Supplier</div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card p-3">
                    <canvas id="stockChart"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-primary text-white p-3 mb-2">
                    <h5>Total Items</h5>
                    <hr>
                    <p class="stat-number">60 Items</p>
                </div>
                <div class="card bg-danger text-white p-3">
                    <h5>Zero Stock Items</h5>
                    <hr>
                    <p class="stat-number">1 Items</p>
                </div>
                <div class="card bg-primary text-white p-3 mb-2">
                    <h5>Total Items</h5>
                    <hr>
                    <p class="stat-number">60 Items</p>
                </div>
            </div>
        </div>

        <div class="card p-3 mt-4">
            <h4>Filter product</h4>
            <div class="selection">
                <form method="GET" action="#">
                    <input
                        type="text"
                        id="form-control"
                        name="query"
                        class="form-control"
                        placeholder="Search...."
                        aria-label="Search"
                        value="<?= htmlspecialchars($_GET['query'] ?? '') ?>">
                </form>

                <select class="form-select" aria-label="Default select example">
                    <option selected>Select category</option>
                    <option value="1">plastic</option>
                    <option value="2">Iron</option>
                    <option value="3">plastic</option>
                </select>

            </div>
            <script>
                document.getElementById('form-control').addEventListener('keyup', filterProductsByName);

                function filterProductsByName() {
                    const input = document.getElementById("form-control");
                    const filter = input.value.toUpperCase();

                    const table = document.getElementById("productTable");
                    const rows = table.getElementsByTagName("tr");
                    let visibleRowCount = 0;

                    for (let i = 1; i < rows.length; i++) {
                        const nameCell = rows[i].getElementsByTagName("td")[1];
                        const priceCell = rows[i].getElementsByTagName("td")[3];

                        if (nameCell && priceCell) {
                            const nameValue = nameCell.textContent || nameCell.innerText;
                            const priceValue = parseFloat(priceCell.textContent || priceCell.innerText);

                            const matchesName = nameValue.toUpperCase().includes(filter);
                            const matchesPrice = priceValue.toString().includes(filter);

                            if (matchesName || matchesPrice) {
                                rows[i].style.display = "";
                                visibleRowCount++;
                            } else {
                                rows[i].style.display = "none";
                            }
                        }
                    }

                    const noProductsMessage = document.getElementById("no-products-message");
                    if (visibleRowCount === 0) {
                        noProductsMessage.style.display = "";
                    } else {
                        noProductsMessage.style.display = "none";
                    }
                }
            </script>

            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                <table id="productTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Unit</th>
                            <th>Quanlity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products) && is_array($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?= htmlspecialchars($product['product_id']) ?></td>
                                    <td><img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width: 50px; height: 50px; border-radius: 50px" ></td>

                                    <td><?= htmlspecialchars($product['name']) ?></td>
                                    <td><?= htmlspecialchars($product['description']) ?></td>
                                    <td><?= htmlspecialchars($product['price']) ?></td>
                                    <td><?= htmlspecialchars($product['unit']) ?></td>
                                    <td><?= htmlspecialchars($product['quantity']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">There Are No Products.</td>
                            </tr>
                        <?php endif; ?>
                        <!-- Placeholder for "Product not found" message -->
                        <tr id="no-products-message" style="display: none;">
                            <td colspan="6" class="text-center text-danger">Not Porduct Found !!</td>
                        </tr>
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    <script>
        const ctx = document.getElementById('stockChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['A', 'B', 'C', 'D', 'E', 'F', 'G'],
                datasets: [{
                        label: 'Low Stock',
                        data: [5, 7, 6, 4, 7, 6, 5],
                        backgroundColor: 'red'
                    },
                    {
                        label: 'High Stock',
                        data: [8, 10, 9, 6, 10, 9, 8],
                        backgroundColor: 'blue'
                    }
                ]
            }
        });
    </script>
</body>

</html>