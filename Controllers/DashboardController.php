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
        $totalProducts = $this->product->getTotalProducts();
        $products = $this->product->getAllProducts(); 
        $totalQuantity = $this->product->getTotalQuantity(); 
        $totalPrice = $this->product->getTotalPrice(); 
        $totalLowStock = $this->product->getLowStockCount(); 
        
        $this->view('dashboard/dashboard', [
            'products' => $products,
            'totalProducts' => $totalProducts,
            'totalQuantity' => $totalQuantity,
            'totalPrice' => $totalPrice,
            'totalLowStock' => $totalLowStock,
        ]);
    }



    
    
    
    

   

    
}

