<?php
require_once "BaseController.php";
require_once "Models/ProductListModel.php";

class ProductListController extends BaseController {
    private $list;

    public function __construct() {
        $this->list = new ProductListModel();
    }

    // Fetch all products with stock details
    public function product_list() {
        $stockList = $this->list->getProductStockList();

        $this->view('products/product_list', [
            'products' => $stockList,
            'searchQuery' => '' // Default empty search query
        ]);
    }

    // Search products by name (supports both AJAX and regular requests)
    public function search() {
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                 strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        $searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';
        $products = (!empty($searchQuery)) ? 
            $this->list->searchProductByName($searchQuery) : 
            $this->list->getProductStockList();

        if ($isAjax) {
            // Return JSON response for AJAX requests
            header('Content-Type: application/json');
            echo json_encode(['products' => $products]);
            exit;
        }

        // Render view for regular requests
        $this->view('products/product_list', [
            'products' => $products,
            'searchQuery' => $searchQuery
        ]);
    }

    // Placeholder for edit method (not implemented in your original)
    public function edit($product_id) {
        // Implement edit logic here if needed
        die("Edit method not implemented for product ID: " . htmlspecialchars($product_id));
    }

    // Placeholder for destroy method (not implemented in your original)
    public function destroy($product_id) {
        // Implement delete logic here if needed
        die("Destroy method not implemented for product ID: " . htmlspecialchars($product_id));
    }
}