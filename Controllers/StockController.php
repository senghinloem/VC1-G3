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

        // Debugging to confirm data is fetched
        if (empty($stock_management)) {
            echo "No data found!";
            exit();
        }

        $this->view("stocks/stock", ["stock_management" => $stock_management]);
    }



    public function view_stock($stock_id)
    {
        $stock = $this->stockModel->getStockById($stock_id);

        if ($stock) {
            $this->view('stocks/view_stock', ['stock' => $stock]);
        } else {
            echo "Stock not found.";
        }
    }

    public function create_stock()
    {
        $status = isset($_GET['status']) ? $_GET['status'] : 'in_stock';
        $this->view("stocks/create_stock", ['status' => $status]);
    }

    public function edit($stock_id)
    {
        $stock = $this->stockModel->getStockById($stock_id);
        if ($stock) {
            $this->view('stocks/edit', ['stock' => $stock]);
        } else {
            echo "Stock not found.";
        }
    }

    public function store()
    {
        if (!isset($_POST['stock_name']) || empty(trim($_POST['stock_name']))) {
            // Show an error message on the same page, so user can try again
            $this->view("stocks/create_stock", ['error' => 'Stock name is required.']);
            return;
        }

        $stock_name = trim($_POST['stock_name']);
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 0;
        $status = ($quantity > 0) ? 'in_stock' : 'out_of_stock';

        try {
            // Pass both stock_name and status to the addStock method
            $this->stockModel->addStock($stock_name, $status);
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

    public function destroy($stock_id)
    {
        $this->stockModel->deleteStock($stock_id);
        header("Location: /stock");
        exit();
    }
    public function searchStockByName()
    {
        if (isset($_GET['stock_name']) && !empty(trim($_GET['stock_name']))) {
            $stock_name = $_GET['stock_name'];
            $stocks = $this->stockModel->searchStockByName($stock_name);
        } else {
            // If no search term, show all stock
            $stocks = $this->stockModel->getStock();
        }

        // Render the view with the stock data
        $this->view('stocks/stock_list', ['stocks' => $stocks]);
    }


    // Method for filtering stock by status (In Stock / Out of Stock)
    public function filterByStockStatus($status)
    {
        // Validate the status parameter ('in_stock' or 'out_of_stock')
        if ($status === 'in_stock' || $status === 'out_of_stock') {
            // Call the model method to filter stocks by the status
            $stocks = $this->stockModel->searchByStockStatus($status);
        } else {
            // If status is invalid, show all stock
            $stocks = $this->stockModel->getStock();
        }

        // Render the view with filtered stock data
        $this->view('stocks/stock_list', ['stocks' => $stocks]);
    }
}
