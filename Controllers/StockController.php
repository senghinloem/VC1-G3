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
    

}
?>
