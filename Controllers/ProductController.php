<?php

require_once "Models/ProductModel.php" ;

class ProductController extends BaseController
{

    private $product;

    public function __construct() {
        $this->product = new ProductModel();
    }

    public function product() {
        $products = $this->product->getAllProducts();
        $this->view('products/products', ['products' => $products]); 
    }
    
    public function create() {
        $this->view('products/create');
    }

    public function store() {
        $image = $_POST['image'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = floatval($_POST['price']);
        $unit = $_POST['unit'];
        $stock = intval($_POST['stock']);
        $this->product->addProduct($image, $name, $description, $price, $unit, $stock);
        header("Location: /products");
        exit();
    }
    

    public function delete($product_id) {
        $this->product->deleteProduct($product_id);
        header("Location: /products");
    }
}

?>