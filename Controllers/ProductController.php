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
        if (!empty($_FILES['image']['name'])) {
            $imageInfo = getimagesize($_FILES['image']['tmp_name']);
            
            if ($imageInfo !== false) {
                $uploadDir = "uploads/";
                $imageName = time() . "_" . basename($_FILES['image']['name']); 
                $imagePath = $uploadDir . $imageName;

                move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
            } else {
                echo "Invalid file type. Only image files are allowed.";
                exit();
            }
        } elseif (!empty($_POST['image_url'])) {
            $imagePath = filter_var($_POST['image_url'], FILTER_VALIDATE_URL) ? $_POST['image_url'] : "uploads/default.png";
        } else {
            $imagePath = "uploads/default.png"; 
        }
        
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = floatval($_POST['price']);
        $unit = $_POST['unit'];
        $quantity = intval($_POST['quantity']);
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