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
        $imagePath = "uploads/default.png"; 
    
        if (!empty($_FILES['image']['name'])) {
            $imageInfo = getimagesize($_FILES['image']['tmp_name']);
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    
            if ($imageInfo && in_array($imageInfo['mime'], $allowedTypes)) {
                $uploadDir = "uploads/";
                $imageName = time() . "_" . basename($_FILES['image']['name']);
                $imagePath = $uploadDir . preg_replace("/[^a-zA-Z0-9.\-_]/", "", $imageName);
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                    die("Error uploading the file.");
                }
            } else {
                die("Invalid image file. Only JPG, PNG, GIF, and WEBP files are allowed.");
            }
        } elseif (!empty($_POST['image_url']) && filter_var($_POST['image_url'], FILTER_VALIDATE_URL)) {
            $imagePath = $_POST['image_url'];
        }

        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $price = floatval($_POST['price']);
        $unit = trim($_POST['unit']);
        $quantity = intval($_POST['quantity']);

        if (!$name || !$price || !$quantity || $price <= 0 || $quantity < 0) {
            die("Invalid input. Please check required fields.");
        }

        $this->product->addProduct($imagePath, $name, $description, $price, $unit, $quantity);

        header("Location: /products");
        exit();
    }
    

    public function delete($product_id) {
        $this->product->deleteProduct($product_id);
        header("Location: /products");
    }
}

?>