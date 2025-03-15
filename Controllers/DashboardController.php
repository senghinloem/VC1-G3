<?php
require_once "Models/DashboardModel.php";

class DashboardController extends BaseController
{
    private $product;

    public function __construct()
    {
        $this->product = new DashboardModel();
    }

    public function product()
    {
        $products = $this->product->getAllProducts();
        $this->view('dashboard/dashboard', ['products' => $products]);
    }

    public function dashboard()
    {
        // Example: Redirect to the product method for simplicity
        $this->product();
    }
}

