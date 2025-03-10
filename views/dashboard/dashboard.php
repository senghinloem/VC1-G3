<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card { border-radius: 10px; }
        .stat-number { font-size: 1.5rem; font-weight: bold; }
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
            </div>
        </div>
        
        <div class="card p-3 mt-4">
            <h4>Filter product</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>SNo</th>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Brand Name</th>
                        <th>Category Name</th>
                        <th>Expiry Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>IT0001</td>
                        <td>Orange</td>
                        <td>N/D</td>
                        <td>Fruits</td>
                        <td>12-12-2022</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>IT0002</td>
                        <td>Pineapple</td>
                        <td>N/D</td>
                        <td>Fruits</td>
                        <td>25-11-2022</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>IT0003</td>
                        <td>Stawberry</td>
                        <td>N/D</td>
                        <td>Fruits</td>
                        <td>19-11-2022</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>IT0004</td>
                        <td>Avocat</td>
                        <td>N/D</td>
                        <td>Fruits</td>
                        <td>20-11-2022</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('stockChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['A', 'B', 'C', 'D', 'E', 'F', 'G'],
                datasets: [
                    { label: 'Low Stock', data: [5, 7, 6, 4, 7, 6, 5], backgroundColor: 'red' },
                    { label: 'High Stock', data: [8, 10, 9, 6, 10, 9, 8], backgroundColor: 'blue' }
                ]
            }
        });
    </script>
</body>
</html>
