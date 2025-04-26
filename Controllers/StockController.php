<?php
require_once "Models/StockModel.php";

class StockController extends BaseController
{
    private $stockModel;

    public function __construct()
    {
        $this->stockModel = new StockModel();
    }

    public function stock()
    {
        $stock_management = $this->stockModel->getStock();
        $this->view("stocks/stock", ["stock_management" => $stock_management]);
    }

    public function create_stock()
    {
        $products = $this->stockModel->getProducts();
        $this->view("stocks/create_stock", ["products" => $products]);
    }

    public function view_detail($stock_id)
    {
        if (!$this->stockModel->validateStockId($stock_id)) {
            $this->redirect('/stock?error=Stock item does not exist');
            return;
        }
        $stock = $this->stockModel->getStockById($stock_id);
        if ($stock) {
            $this->view('stocks/view_stock', ['stock' => $stock]);
        } else {
            $this->redirect('/stock?error=Stock not found');
        }
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/stock/create');
            return;
        }

        if (!isset($_POST['stock_name']) || empty(trim($_POST['stock_name']))) {
            $products = $this->stockModel->getProducts();
            $this->view("stocks/create_stock", ['error' => 'Stock name is required.', 'products' => $products]);
            return;
        }

        if (!isset($_POST['product_id']) || empty($_POST['product_id'])) {
            $products = $this->stockModel->getProducts();
            $this->view("stocks/create_stock", ['error' => 'Product is required.', 'products' => $products]);
            return;
        }

        if (!isset($_POST['quantity']) || !is_numeric($_POST['quantity']) || (int)$_POST['quantity'] < 0 || (int)$_POST['quantity'] > 500) {
            $products = $this->stockModel->getProducts();
            $this->view("stocks/create_stock", ['error' => 'Valid quantity (0-500) is required.', 'products' => $products]);
            return;
        }

        $stock_name = trim($_POST['stock_name']);
        $product_id = (int)$_POST['product_id'];
        $quantity = (int)$_POST['quantity'];
        $user_id = $this->getCurrentUserId(); // Get current user ID from session

        if (!$this->stockModel->validateProductId($product_id)) {
            $products = $this->stockModel->getProducts();
            $this->view("stocks/create_stock", ['error' => 'Selected product does not exist.', 'products' => $products]);
            return;
        }

        try {
            if ($this->stockModel->addStock($stock_name, $product_id, $quantity, $user_id)) {
                $this->redirect('/stock?success=Stock added successfully');
            } else {
                $products = $this->stockModel->getProducts();
                $this->view("stocks/create_stock", ['error' => 'Failed to add stock. Invalid product or data.', 'products' => $products]);
            }
        } catch (PDOException $e) {
            $products = $this->stockModel->getProducts();
            $error_message = $e->getCode() == '23000' ? 'Invalid product or stock already exists.' : 'An error occurred: ' . $e->getMessage();
            $this->view("stocks/create_stock", ['error' => $error_message, 'products' => $products]);
        }
    }

    public function destroy($stock_id)
    {
        try {
            if (!$this->stockModel->validateStockId($stock_id)) {
                $this->redirect('/stock?error=Stock item does not exist');
                return;
            }
            $success = $this->stockModel->deleteStock($stock_id);
            if ($success) {
                $this->redirect('/stock?success=Stock deleted successfully');
            } else {
                $this->redirect('/stock?error=Failed to delete stock');
            }
        } catch (Exception $e) {
            error_log("Delete error for stock_id $stock_id: " . $e->getMessage());
            $this->redirect('/stock?error=Failed to delete stock');
        }
    }

    public function search()
    {
        $search_term = $_GET['search'] ?? '';
        $stock_management = $this->stockModel->searchStock($search_term);
        $this->view("stocks/stock", ["stock_management" => $stock_management]);
    }

    public function edit($stock_id)
    {
        if (!$this->stockModel->validateStockId($stock_id)) {
            $this->redirect('/stock?error=Stock item does not exist');
            return;
        }
        $stock = $this->stockModel->getStockById($stock_id);
        $products = $this->stockModel->getProducts();
        if ($stock) {
            $this->view('stocks/edit', ['stock' => $stock, 'products' => $products]);
        } else {
            $this->redirect('/stock?error=Stock not found');
        }
    }

    public function update($stock_id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/stock/edit/' . $stock_id);
            return;
        }

        if (!$this->stockModel->validateStockId($stock_id)) {
            $this->redirect('/stock?error=Stock item does not exist');
            return;
        }

        if (!isset($_POST['stock_name']) || empty(trim($_POST['stock_name']))) {
            $stock = $this->stockModel->getStockById($stock_id);
            $products = $this->stockModel->getProducts();
            $this->view("stocks/edit", [
                'error' => 'Stock name is required.',
                'stock' => $stock ?? ['stock_id' => $stock_id],
                'products' => $products
            ]);
            return;
        }

        if (!isset($_POST['product_id']) || empty($_POST['product_id'])) {
            $stock = $this->stockModel->getStockById($stock_id);
            $products = $this->stockModel->getProducts();
            $this->view("stocks/edit", [
                'error' => 'Product is required.',
                'stock' => $stock ?? ['stock_id' => $stock_id],
                'products' => $products
            ]);
            return;
        }

        if (!isset($_POST['quantity']) || !is_numeric($_POST['quantity']) || (int)$_POST['quantity'] < 0 || (int)$_POST['quantity'] > 500) {
            $stock = $this->stockModel->getStockById($stock_id);
            $products = $this->stockModel->getProducts();
            $this->view("stocks/edit", [
                'error' => 'Valid quantity (0-500) is required.',
                'stock' => $stock ?? ['stock_id' => $stock_id],
                'products' => $products
            ]);
            return;
        }

        $stock_name = trim($_POST['stock_name']);
        $product_id = (int)$_POST['product_id'];
        $quantity = (int)$_POST['quantity'];

        if (!$this->stockModel->validateProductId($product_id)) {
            $stock = $this->stockModel->getStockById($stock_id);
            $products = $this->stockModel->getProducts();
            $this->view("stocks/edit", [
                'error' => 'Selected product does not exist.',
                'stock' => $stock ?? ['stock_id' => $stock_id],
                'products' => $products
            ]);
            return;
        }

        try {
            $success = $this->stockModel->updateStock($stock_id, $stock_name, $product_id, $quantity);
            if ($success) {
                $this->redirect('/stock?success=Stock updated successfully');
            } else {
                $stock = $this->stockModel->getStockById($stock_id);
                $products = $this->stockModel->getProducts();
                $this->view("stocks/edit", [
                    'error' => 'Failed to update stock. Please check the product and quantity.',
                    'stock' => [
                        'stock_id' => $stock_id,
                        'stock_name' => $stock_name,
                        'product_id' => $product_id,
                        'quantity' => $quantity,
                        'status' => $quantity > 0 ? 'in_stock' : 'out_of_stock'
                    ],
                    'products' => $products
                ]);
            }
        } catch (Exception $e) {
            $stock = $this->stockModel->getStockById($stock_id);
            $products = $this->stockModel->getProducts();
            $this->view("stocks/edit", [
                'error' => 'An error occurred: ' . $e->getMessage(),
                'stock' => [
                    'stock_id' => $stock_id,
                    'stock_name' => $stock_name,
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'status' => $quantity > 0 ? 'in_stock' : 'out_of_stock'
                ],
                'products' => $products
            ]);
        }
    }

    public function adjust($stock_id)
{
    if (!$this->stockModel->validateStockId($stock_id)) {
        $this->redirect('/stock?error=Stock item does not exist');
        return;
    }
    
    $stock = $this->stockModel->getStockById($stock_id);
    if (!$stock) {
        $this->redirect("/stock?error=Stock not found.");
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        // Show the adjustment form
        $this->view('stocks/adjust_stock', ['stock' => $stock]);
        return;
    }

    // Process the form submission
    $add = isset($_POST['add_quantity']) ? (int)$_POST['add_quantity'] : 0;
    $subtract = isset($_POST['subtract_quantity']) ? (int)$_POST['subtract_quantity'] : 0;

    // Validate quantities
    if ($add < 0 || $subtract < 0) {
        $this->redirect("/stock/view/{$stock_id}?error=Quantities cannot be negative");
        return;
    }

    if ($add === 0 && $subtract === 0) {
        $this->redirect("/stock/view/{$stock_id}?error=No adjustment made");
        return;
    }

    if ($subtract > ($stock['stock_quantity'] + $add)) {
        $this->redirect("/stock/view/{$stock_id}?error=Subtract quantity exceeds available stock");
        return;
    }

    $new_quantity = max(0, $stock['stock_quantity'] + $add - $subtract);
    if ($new_quantity > 500) {
        $new_quantity = 500;
    }

    try {
        $success = $this->stockModel->updateStock(
            $stock_id, 
            $stock['stock_name'], 
            $stock['product_id'], 
            $new_quantity
        );
        
        if ($success) {
            // Redirect to stock listing page after successful adjustment
            $this->redirect("/stock?success=Stock adjusted successfully");
        } else {
            $this->redirect("/stock?error=Failed to adjust stock");
        }
    } catch (Exception $e) {
        error_log("Adjustment error for stock_id $stock_id: " . $e->getMessage());
        $this->redirect("/stock?error=Failed to adjust stock: " . $e->getMessage());
    }
}

    private function getCurrentUserId()
    {
        // Implement your own logic to get the current user ID from session
        return $_SESSION['user_id'] ?? 1; // Default to 1 if not set
    }
}