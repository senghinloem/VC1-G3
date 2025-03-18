<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- style layout -->
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- icon -->
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />


    <link rel="stylesheet" href="../../views/assets/css/dashboard.css">

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
        <?php $text = "$ " ?>


        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Products</p>
                                    <h5 class="font-weight-bolder">
                                        <?= $totalProducts; ?>
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder">+55%</span>
                                        since yesterday
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Items</p>
                                    <h5 class="font-weight-bolder">
                                        <?= $totalQuantity; ?>
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder">+3%</span>
                                        since last week
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Price</p>
                                    <h5 class="font-weight-bolder">
                                        <?= $text . $totalPrice ?>
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-danger text-sm font-weight-bolder">-2%</span>
                                        since last quarter
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Low Stock</p>
                                    <h5 class="font-weight-bolder">
                                        <?= $totalLowStock ?>
                                    </h5>
                                    <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder">+5%</span> than last month
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

        <script>

        </script>

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

                <select id="form-select" class="form-select" aria-label="Default select example">
                    <option selected value="">Select by unit</option>
                    <?php
                    $units = [];
                    foreach ($products as $product) {
                        if (!empty($product['unit']) && !in_array($product['unit'], $units)) {
                            $units[] = $product['unit'];
                            echo '<option value="' . htmlspecialchars($product['unit']) . '">' . htmlspecialchars($product['unit']) . '</option>';
                        }
                    }
                    ?>
                </select>


            </div>
            <script>
                document.getElementById('form-select').addEventListener('change', function() {
                    const selectedUnit = this.value.toUpperCase();
                    const table = document.getElementById("productTable");
                    const rows = table.getElementsByTagName("tr");

                    for (let i = 1; i < rows.length; i++) { // Skip header row
                        const unitCell = rows[i].getElementsByTagName("td")[5]; // Unit column
                        if (unitCell) {
                            const unitValue = unitCell.textContent || unitCell.innerText;
                            if (selectedUnit === "" || unitValue.toUpperCase() === selectedUnit) {
                                rows[i].style.display = ""; // Show row
                            } else {
                                rows[i].style.display = "none"; // Hide row
                            }
                        }
                    }
                });
            </script>
            <script>
                document.getElementById('form-control').addEventListener('keyup', filterProductsByName);

                function filterProductsByName() {
                    const input = document.getElementById("form-control");
                    const filter = input.value.toUpperCase();

                    const table = document.getElementById("productTable");
                    const rows = table.getElementsByTagName("tr");
                    let visibleRowCount = 0;

                    for (let i = 1; i < rows.length; i++) {
                        const nameCell = rows[i].getElementsByTagName("td")[2];
                        const priceCell = rows[i].getElementsByTagName("td")[4];

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
                                    <td><img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width: 50px; height: 50px; border-radius: 50px; object-fit: cover"></td>

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
        const products = <?= json_encode($products); ?>;
        const labels = products.map(product => product.name);
        const lowStockData = products.map(product => product.quantity < 5 ? product.quantity : 0);
        const highStockData = products.map(product => product.quantity >= 5 ? product.quantity : 0);

        const ctx = document.getElementById('stockChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Low Stock',
                        data: lowStockData,
                        backgroundColor: 'red',
                    },
                    {
                        label: 'High Stock',
                        data: highStockData,
                        backgroundColor: 'blue',
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
            },
        });
    </script>






</body>


</html>