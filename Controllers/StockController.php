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

    public function create_stock () {
        $this->view("products/create_stock");

    }

    public function store() {
        $quantity = $_POST['quantity'];
        $stock_type = $_POST['stock_type'];

        $this->stockModel->addStock($quantity, $stock_type);
        header("Location: /products/stock");
    }

    public function edit($stock_id) {
        $stock = $this->stockModel->getStockById($stock_id);
        $this->view("products/edit_stock", ["stock" => $stock]);
    }

    public function update($stock_id) {
        $quantity = $_POST['quantity'];
        $stock_type = $_POST['stock_type'];

        $this->stockModel->updateStock($stock_id, $quantity, $stock_type);
        header("Location: /products/stock");
    }

    public function delete($stock_id) {
        $this->stockModel->deleteStock($stock_id);
        header("Location: /products/stock");
    }
    
}
?>
