<?php
require_once "Models/DashboardModel.php";

class DashboardController extends BaseController
{
    public $product;
    public function __construct()
    {
        $this->product = new DashboardModel();
    }
    public function product()
    {
        $products = $this->product->getAllProducts();
        $this->view('dashboard/dashboard', ['products' => $products]);
    }

}
