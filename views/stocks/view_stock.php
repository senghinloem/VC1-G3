<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional: Custom CSS for additional styling -->
    <style>
        .action-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        .btn-plus {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-minus {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .table-container {
            width: 90%; /* Adjusted to give it more space */
        }
    </style>
</head>
<body>
    <div class="container mt-4 table-container mx-auto">
        <!-- Search Bar -->
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="search for ..." aria-label="Search">
            <button class="btn btn-primary" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
            </button>
        </div>
        <h4>View all stock</h4>

        <!-- Table -->
        <table class="table table-bordered mt-4 table-sm mx-auto">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Items</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Plastic plate</td>
                    <td>100</td>
                    <td class="d-flex">
                        <button class="btn btn-plus text-white action-btn ms-4">+</button>
                        <button class="btn btn-minus text-white action-btn ms-4">−</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Plastic plate</td>
                    <td>100</td>
                    <td class="d-flex">
                        <button class="btn btn-plus text-white action-btn ms-4">+</button>
                        <button class="btn btn-minus text-white action-btn ms-4">−</button>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Plastic plate</td>
                    <td>100</td>
                    <td class="d-flex">
                        <button class="btn btn-plus text-white action-btn ms-4">+</button>
                        <button class="btn btn-minus text-white action-btn ms-4">−</button>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Plastic plate</td>
                    <td>100</td>
                    <td class="d-flex">
                        <button class="btn btn-plus text-white action-btn ms-4">+</button>
                        <button class="btn btn-minus text-white action-btn ms-4">−</button>
                    </td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Plastic plate</td>
                    <td>100</td>
                    <td class="d-flex">
                        <button class="btn btn-plus text-white action-btn ms-4">+</button>
                        <button class="btn btn-minus text-white action-btn ms-4">−</button>
                    </td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Plastic plate</td>
                    <td>100</td>
                    <td class="d-flex">
                        <button class="btn btn-plus text-white action-btn ms-4">+</button>
                        <button class="btn btn-minus text-white action-btn ms-4">−</button>
                    </td>
                </tr>
            </tbody>
        </table>   
    </div>
    

    <!-- Bootstrap JS (Optional, for interactive components if needed) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
