


<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="input-group w-50">
            <input type="text" id="searchInput" class="form-control" placeholder="Search for product...">
            <button class="btn btn-outline-secondary" type="button">
                <i class="bi bi-search"></i>
            </button>
        </div>
        <div>
            <a href="/create" class="btn btn-primary">Add Product</a>
            
            <input type="file" id="excelFileInput" accept=".xlsx, .xls" style="display: none;">
            
            <button class="btn btn-dark" id="importProductsButton">Import Products</button>
        </div>
    </div>
    
    <h4>Products</h4>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">Product Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price($)</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Add to stock</th>
                    <th scope="col">Delete from table</th>
                </tr>
            </thead>
            <tbody id="productTableBody">
                <?php if (!empty($products) && is_array($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width: 100px; height: 100px;"></td>
                            <td><?= htmlspecialchars($product['name']) ?></td>
                            <td><?= htmlspecialchars($product['description']) ?></td>
                            <td><?= htmlspecialchars($product['price']) ?></td>
                            <td><?= htmlspecialchars($product['unit']) ?></td>
                            <td><?= htmlspecialchars($product['quantity']) ?></td>
                            <td>
                                <a href="" class="btn btn-primary">ADD</a>
                            </td>
                            <td>
                                <a href="/products/destroy/<?= $product["product_id"]?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">There Is No products.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <button class="btn btn-dark mt-3 mb-3">Add to Stock</button>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>

document.getElementById('searchInput').addEventListener('input', function() {
    const searchValue = this.value.toLowerCase();
    const rows = document.querySelectorAll('#productTableBody tr');

    rows.forEach(row => {
        const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
        const price = row.querySelector('td:nth-child(4)').textContent; 
        const unit = row.querySelector('td:nth-child(5)').textContent; 
        const quantity = row.querySelector('td:nth-child(6)').textContent; 

        if (
            name.includes(searchValue) || 
            price.includes(this.value) || 
            unit.includes(this.value) || 
            quantity.includes(this.value) 
        ) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});


document.getElementById('importProductsButton').addEventListener('click', function() {
    document.getElementById('excelFileInput').click(); 
});

document.getElementById('excelFileInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        const data = new Uint8Array(e.target.result);
        const workbook = XLSX.read(data, { type: 'array' });

        
        const sheetName = workbook.SheetNames[0];
        const sheet = workbook.Sheets[sheetName];

        
        const jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

        
        const tableBody = document.getElementById('productTableBody');
        jsonData.slice(1).forEach(row => { 
            const newRow = document.createElement('tr');

            
            const columns = [
                `<td><img src="${row[0]}" alt="${row[1]}" style="width: 100px; height: 100px;"></td>`, 
                `<td>${row[1]}</td>`, 
                `<td>${row[2]}</td>`, 
                `<td>${row[3]}</td>`, 
                `<td>${row[4]}</td>`, 
                `<td>${row[5]}</td>`, 
                `<td><a href="" class="btn btn-primary">ADD</a></td>`, 
                `<td><a href="/products/destroy/${row[6]}" class="btn btn-danger">Delete</a></td>` 
            ];

            columns.forEach(column => {
                newRow.innerHTML += column;
            });

            tableBody.appendChild(newRow);
        });
    };

    reader.readAsArrayBuffer(file);
});
</script>