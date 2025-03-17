<?php

require_once "Models/StockModel.php";

class StockController extends BaseController
{
    private $stockModel;

    public function __construct()
    {
        $this->stockModel = new StockModel();
    }

    public function view_stock()
    {
        if (isset($_GET['stock_id']) && !empty($_GET['stock_id'])) {
            $stock_id = $_GET['stock_id']; // Get the stock_id from the query string

            // Fetch the stock details from the model using the stock_id
            $stock = $this->stockModel->getStockById($stock_id);

            if ($stock) {
                // Pass the stock data to the view
                $this->view('stocks/view_stock', ['stock' => $stock]);
            } else {
                echo "Stock not found.";
            }
        } else {
            echo "Stock ID is required.";
        }
    }

    public function stock()
    {
        $stock_management = $this->stockModel->getStock();
        $this->view("stocks/stock", ["stock_management" => $stock_management]);
    }

    public function create_stock()
    {
        $this->view("stocks/create_stock");
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
}
