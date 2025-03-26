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


    public function edit($product_id) {
        // Fetch the product details
        $products = $this->list->getProductListById($product_id);
        
        // Check if product exists
        if (empty($products)) {
            $_SESSION['error'] = "Product not found";
            header("Location: /product_list");
            exit;
        }

        // Since getProductListById returns an array, take the first element
        $product = $products[0];

        // Render the edit view with product data
        $this->view('products/edit_list', [
            'product' => $product
        ]);
    }
    // Update product details
    public function update($product_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and sanitize input
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $unit = filter_input(INPUT_POST, 'unit', FILTER_SANITIZE_STRING);

            // Basic validation
            if (empty($name) || empty($price) || empty($unit)) {
                $_SESSION['error'] = "Please fill in all required fields";
                $this->view('products/product_edit', [
                    'product' => $this->list->getProductListById($product_id)[0]
                ]);
                return;
            }

            try {
                $result = $this->list->updateProduct($product_id, $name, $description, $price, $unit);
                
                if ($result) {
                    $_SESSION['success'] = "Product updated successfully";
                    header("Location: /product_list");
                    exit;
                } else {
                    $_SESSION['error'] = "Failed to update product";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Error updating product: " . $e->getMessage();
            }
        }

        // If not POST, show the edit form
        $this->edit($product_id);
    }

    // Delete a product
    public function destroy($product_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $products = $this->list->getProductListById($product_id);
                
                if (empty($products)) {
                    $_SESSION['error'] = "Product not found";
                    header("Location: /product_list");
                    exit;
                }

                $result = $this->list->deleteProduct($product_id);
                
                if ($result) {
                    $_SESSION['success'] = "Product deleted successfully";
                } else {
                    $_SESSION['error'] = "Failed to delete product";
                }
            } catch (Exception $e) {
                $_SESSION['error'] = "Error deleting product: " . $e->getMessage();
            }
            
            header("Location: /product_list");
            exit;
        }

        // If not POST, redirect to product list
        header("Location: /product_list");
        exit;
    }
}