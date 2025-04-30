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
        /* Custom styles for the filter section */
        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #searchInput {
            height: 40px;
        }
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
                                        of 650 products
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

        <div class="card p-3 mt-4">
            <div class="filter-header">
                <h4>Filter product</h4>
                <div class="selection">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search...." aria-label="Search">
                    <select id="unitSelect" class="form-select" aria-label="Default select example">
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
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody">
                        <!-- Table rows will be populated by JavaScript -->
                    </tbody>
                </table>
                <div id="no-products-message" class="text-center text-danger" style="display: none;">
                    No Products Found!
                </div>
            </div>

            <!-- Pagination UI -->
            <div class="d-flex justify-content-end mt-3">
                <nav aria-label="Page navigation">
                    <ul class="pagination mb-0" id="pagination"></ul>
                </nav>
            </div>
        </div>
    </div>

    <script>
        // Product data from PHP
        const products = <?= json_encode($products); ?>;
        const productsPerPage = 5;
        let currentPage = 1;
        let filteredProducts = products;

        // Log the products array to debug
        console.log('Products:', products);

        // Function to render table rows with default image handling
        function renderTable(productsToShow) {
            const tableBody = document.getElementById('productTableBody');
            tableBody.innerHTML = '';

            // Define the default image path (replace with the actual path to your grayed-out placeholder icon)
            const defaultImage = 'views/assets/images/default.png'; // Update this path to match your project's default image

            if (productsToShow.length === 0) {
                document.getElementById('no-products-message').style.display = 'block';
                return;
            }

            document.getElementById('no-products-message').style.display = 'none';

            productsToShow.forEach(product => {
                const row = document.createElement('tr');
                // Check if product.image is empty or invalid, and use default image if so
                const imageSrc = product.image && product.image.trim() !== '' ? product.image : defaultImage;
                row.innerHTML = `
                    <td>${product.product_id}</td>
                    <td><img src="${imageSrc}" alt="${product.name}" style="width: 50px; height: 50px; border-radius: 50px; object-fit: cover"></td>
                    <td>${product.name}</td>
                    <td>${product.description}</td>
                    <td>${product.price}</td>
                    <td>${product.unit}</td>
                    <td>${product.quantity}</td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Function to render pagination
        function renderPagination(totalPages) {
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = '';

            // First page button
            pagination.innerHTML += `
                <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="1" aria-label="First">«</a>
                </li>
            `;

            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                pagination.innerHTML += `
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>
                `;
            }

            // Last page button
            pagination.innerHTML += `
                <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${totalPages}" aria-label="Last">»</a>
                </li>
            `;

            // Add event listeners to pagination links
            document.querySelectorAll('.page-link').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const page = parseInt(e.target.dataset.page);
                    if (page && page !== currentPage) {
                        currentPage = page;
                        updateTable();
                    }
                });
            });
        }

        // Function to filter and update table
        function updateTable() {
            const searchQuery = document.getElementById('searchInput').value.toUpperCase();
            const selectedUnit = document.getElementById('unitSelect').value.toUpperCase();

            // Filter products
            filteredProducts = products.filter(product => {
                const matchesSearch = product.name.toUpperCase().includes(searchQuery) ||
                    product.price.toString().includes(searchQuery);
                const matchesUnit = selectedUnit === '' || product.unit.toUpperCase() === selectedUnit;
                return matchesSearch && matchesUnit;
            });

            // Log filtered products to debug
            console.log('Filtered Products:', filteredProducts);

            // Calculate pagination
            const totalPages = Math.ceil(filteredProducts.length / productsPerPage);
            currentPage = Math.min(currentPage, totalPages || 1);

            // Slice products for current page
            const startIndex = (currentPage - 1) * productsPerPage;
            const paginatedProducts = filteredProducts.slice(startIndex, startIndex + productsPerPage);

            // Render table and pagination
            renderTable(paginatedProducts);
            renderPagination(totalPages);
        }

        // Event listeners for filters
        document.getElementById('searchInput').addEventListener('input', () => {
            currentPage = 1; // Reset to first page on search
            updateTable();
        });

        document.getElementById('unitSelect').addEventListener('change', () => {
            currentPage = 1; // Reset to first page on unit change
            updateTable();
        });

        // Stock Chart: Show top 20 products by quantity, including all low stock products
        const lowStockProducts = products.filter(product => product.quantity < 5);
        const highStockProducts = products
            .filter(product => product.quantity >= 5)
            .sort((a, b) => b.quantity - a.quantity);

        const maxChartItems = 20;
        const remainingSlots = maxChartItems - lowStockProducts.length;
        const topHighStockProducts = highStockProducts.slice(0, remainingSlots);
        const chartProducts = [...lowStockProducts, ...topHighStockProducts].sort((a, b) => b.quantity - a.quantity);

        const labels = chartProducts.map(product => product.name);
        const lowStockData = chartProducts.map(product => product.quantity < 5 ? product.quantity : 0);
        const highStockData = chartProducts.map(product => product.quantity >= 5 ? product.quantity : 0);

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
                    legend: {
                        position: 'top'
                    },
                },
                scales: {
                    x: {
                        ticks: {
                            autoSkip: false,
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                }
            },
        });

        // Dynamic Pie Chart for Units
        document.addEventListener('DOMContentLoaded', function() {
            // Reset filters on page load
            document.getElementById('searchInput').value = '';
            document.getElementById('unitSelect').value = '';

            const pieCtx = document.getElementById('pie-chart').getContext('2d');

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

            new Chart(pieCtx, {
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

            // Initial table render
            updateTable();
        });
    </script>
</body>

</html>