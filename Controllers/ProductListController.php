<?php
require_once "Models/ProductListModel.php";

class ProductListController extends BaseController 
{
    private $list;

    public function __construct()
    {
        $this->list = new ProductListModel();
    }

    public function product_list() 
    {
        $stockList = $this->list->getProductStockList();
        $this->view('products/product_list', [
            'products' => $stockList
        ]);
    }

    public function edit($id) 
    {
        $product = $this->list->getProductById($id);
        if (!$product) {
            die("Product not found.");
        }
        $this->view('products/edit_list', ['product' => $product]);
    }

    public function update() 
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (!isset($_POST['product_id']) || empty($_POST['product_id'])) {
                die("Error: Product ID is missing.");
            }
            $id = $_POST['product_id'];
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? 0;
            $unit = $_POST['unit'] ?? '';

            $success = $this->list->updateProduct($id, $name, $description, $price, $unit);
            if ($success) {
                header("Location: /product_list");
                exit();
            } else {
                die("Error: Failed to update product.");
            }
        }else {
            die("Error: Invalid request method.");
        }
    }

    public function destroy($id) 
    {
        $this->list->deleteProduct($id);
        header("Location: /product_list");
        exit();
    }

    public function search() 
    {
        $searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';
        $list = (!empty($searchQuery)) ? $this->list->searchProductByName($searchQuery) : [];
        $this->view('products/product_list', [
            'products' => $list,
            'searchQuery' => $searchQuery
        ]);
    }
}