<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="views/assets/css/dashboard.css" rel="stylesheet" />

    <style>
        .card { border-radius: 10px; }
        .stat-number { font-size: 1.5rem; font-weight: bold; }
        .selection { display: flex; justify-content: flex-end; gap: 1rem; margin-top: 1rem; }
        .selection .form-select { width: auto; min-width: 150px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2>Dashboard</h2>
        <?php
        $text = "$ ";
        $symbol = "%";
        ?>

        <!-- Existing cards remain unchanged -->
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Overall Products</p>
                                    <h5 class="font-weight-bolder"><?= $totalProducts; ?></h5>
                                    <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder"><?= $totalProductsPercentage . $symbol ?></span>
                                        of 650 produts
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
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Item Count</p>
                                    <h5 class="font-weight-bolder"><?= $totalQuantity; ?></h5>
                                    <p class="mb-0">
                                        All the products
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
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Overall Cost</p>
                                    <h5 class="font-weight-bolder"><?= $text . $totalPrice ?></h5>
                                    <p class="mb-0">
                                        <span class="text-success text-sm font-weight-bolder"></span> Product's Price
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
                                    <h5 class="font-weight-bolder"><?= $totalLowStock ?></h5>
                                    <p class="mb-0">
                                        <span class="text-danger text-sm font-weight-bolder"><?= $lowStockPercentage . $symbol ?></span>
                                        Running Low
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

        <div class="row" style="margin-top: 20px;">
            <div class="col-md-8">
                <div class="card p-3">
                    <canvas id="stockChart"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Unit Share</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12"><canvas id="pie-chart"></canvas></div>
                        </div>
                        <span class="float-end text-success">
                            <i class="bi bi-arrow-up fs-7"></i> Allocation unit of inventory
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter product section remains largely unchanged -->
        <div class="card p-3 mt-4">
            <h4>Filter product</h4>
            <div class="selection">
                <form method="GET" action="#">
                    <input type="text" id="form-control" name="query" class="form-control" placeholder="Search...." aria-label="Search" value="<?= htmlspecialchars($_GET['query'] ?? '') ?>">
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
                        <tr id="no-products-message" style="display: none;">
                            <td colspan="6" class="text-center text-danger">Not Porduct Found !!</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Product data from PHP
        const products = <?= json_encode($products); ?>;

        // Stock Chart (unchanged)
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
                }, {
                    label: 'High Stock',
                    data: highStockData,
                    backgroundColor: 'blue',
                }],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                },
            },
        });

        // Dynamic Pie Chart for Units
        document.addEventListener('DOMContentLoaded', function() {
            const pieCtx = document.getElementById('pie-chart').getContext('2d');
            
            // Calculate unit distribution
            const unitCounts = {};
            products.forEach(product => {
                if (product.unit) {
                    unitCounts[product.unit] = (unitCounts[product.unit] || 0) + 1;
                }
            });

            const unitLabels = Object.keys(unitCounts);
            const unitData = Object.values(unitCounts);
            const colors = [
                '#4e73df', '#1cc88a', '#f6c23e', '#e83e8c', 
                '#6f42c1', '#858796', '#36b9cc', '#f8f9fc'
            ].slice(0, unitLabels.length);

            const pieChart = new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: unitLabels,
                    datasets: [{
                        data: unitData,
                        backgroundColor: colors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 15,
                                padding: 20
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '50%'
                }
            });
        });

        // Existing filter functions
        document.getElementById('form-select').addEventListener('change', function() {
            const selectedUnit = this.value.toUpperCase();
            const table = document.getElementById("productTable");
            const rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) {
                const unitCell = rows[i].getElementsByTagName("td")[5];
                if (unitCell) {
                    const unitValue = unitCell.textContent || unitCell.innerText;
                    rows[i].style.display = (selectedUnit === "" || unitValue.toUpperCase() === selectedUnit) ? "" : "none";
                }
            }
        });

        document.getElementById('form-control').addEventListener('keyup', function() {
            const filter = this.value.toUpperCase();
            const table = document.getElementById("productTable");
            const rows = table.getElementsByTagName("tr");
            let visibleRowCount = 0;

            for (let i = 1; i < rows.length; i++) {
                const nameCell = rows[i].getElementsByTagName("td")[2];
                const priceCell = rows[i].getElementsByTagName("td")[4];
                if (nameCell && priceCell) {
                    const nameValue = nameCell.textContent || nameCell.innerText;
                    const priceValue = parseFloat(priceCell.textContent || priceCell.innerText);
                    const matches = nameValue.toUpperCase().includes(filter) || priceValue.toString().includes(filter);
                    rows[i].style.display = matches ? "" : "none";
                    if (matches) visibleRowCount++;
                }
            }
            document.getElementById("no-products-message").style.display = visibleRowCount === 0 ? "" : "none";
        });
    </script>
</body>
</html>