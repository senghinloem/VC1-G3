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
        $this->view("products/stock", ["stock_management" => $stock_management]);
    }
    public function create_stock() {
        $this->view("products/create_stock");
    }
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stock_name = $_POST['stock_name'] ?? '';
            $quantity = $_POST['quantity'] ?? 0;
            $this->stockModel->addStock($stock_name, $quantity);
            header('Location: /stock');
        }
    }
    public function edit($stock)
    {
        $stock_item = $this->stockModel->getStock($stock);
        include 'views/edit_stock_view.php';
    }
    public function update($stock)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stock_name = $_POST['stock_name'] ?? '';
            $quantity = $_POST['quantity'] ?? 0;
            $updated = $this->stockModel->updateStock($stock, $stock_name, $quantity);

            if ($updated) {
                header('Location: /stock');
            } else {
                echo "Failed to update stock.";
            }
        }
    }
    public function delete($stock)
    {
        $this->stockModel->deleteStock($stock);
        header('Location: /stock');
    }
    // public function search()
    // {
    //     $query = $_GET['query'] ?? '';
    //     $stock_management = $this->stockModel->searchStock($query);

    //     // Include the view with filtered search results
    //     include 'views/stock_view.php';
    // }


}
?>