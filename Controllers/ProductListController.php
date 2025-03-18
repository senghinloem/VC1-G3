<?php
require_once "Models/ProductListModel.php";

class ProductListController extends BaseController 
{
    private $list;

    public function __construct()
    {
        $this->list = new ProductListModel();
    }

    // Fetch all products with stock details
    public function product_list() 
    {
        $stockList = $this->list->getProductStockList();

        $this->view('products/product_list', [
            'products' => $stockList // Use 'products' to match the view
        ]);
    }

    // Search products by name
    public function search() 
    {
        $searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';
        $list = (!empty($searchQuery)) ? $this->list->searchProductByName($searchQuery) : [];

        $this->view('products/product_list', [
            'products' => $list, // Ensure consistency
            'searchQuery' => $searchQuery
        ]);
    }
}
