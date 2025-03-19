<?php
require_once "Models/StockModel.php";

class StockController extends BaseController
{
    private $stockModel;

    public function __construct()
    {
        $this->stockModel = new StockModel();
    }

    // Fetch and pass stock data to the view
    public function stock()
    {
        // Fetch stock data
        $stock_management = $this->stockModel->getStock();
    
        // Debugging: Check if data is retrieved properly
        // var_dump($stock_management);
    
        // Pass the stock data to the view
        $this->view('stocks/view_stock', ['stock_management' => $stock_management]);
    }
    
    // View a specific stock item
    public function details($stock_id)
    {
        $stock = $this->stockModel->getStockById($stock_id);
        if ($stock) {
            $this->view('stocks/view_stock', ['stock' => $stock]);
        } else {
            echo "Stock not found.";
        }
    }


   

    // Show create stock form
    public function create_stock()
    {
        $this->view("stocks/create_stock");
    }

    // Show edit form for a stock item
    public function edit($stock_id)
    {
        $stock = $this->stockModel->getStockById($stock_id);
        if ($stock) {
            $this->view('stocks/edit', ['stock' => $stock]);
        } else {
            echo "Stock not found.";
        }
    }

    // Save a new stock item
    public function store()
    {
        if (!isset($_POST['stock_name']) || empty(trim($_POST['stock_name']))) {
            $this->view("stocks/create_stock", ['error' => 'Stock name is required.']);
            return;
        }

        $stock_name = trim($_POST['stock_name']);

        try {
            $this->stockModel->addStock($stock_name);
            header("Location: /stock");
            exit();
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $this->view("stocks/create_stock", ['error' => 'Stock already exists.']);
            } else {
                throw $e;
            }
        }
    }

    // Update an existing stock item
    public function update($stock_id)
    {
        if (!isset($_POST['stock_name']) || empty(trim($_POST['stock_name']))) {
            $this->view("stocks/edit", ['error' => 'Stock name is required.', 'stock_id' => $stock_id]);
            return;
        }

        $stock_name = trim($_POST['stock_name']);

        $this->stockModel->updateStock($stock_id, $stock_name);
        header("Location: /stock");
        exit();
    }

    // Delete a stock item
    public function destroy($stock_id)
    {
        $this->stockModel->deleteStock($stock_id);
        header("Location: /stock");
        exit();
    }
}
?>
