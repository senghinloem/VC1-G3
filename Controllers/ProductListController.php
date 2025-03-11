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
        $list = $this->list->getProductList();
        $this->view('products/product_list', ['product_list' => $list]);
    }

    public function create_list() {
        $this->view("products/create_list");
    }

    public function store() {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
        // Allowed image MIME types
        $allowed_mime_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp', 'image/tiff', 'image/svg+xml'];
    
        // Check if image file is valid
        $check = getimagesize($_FILES["product_image"]["tmp_name"]);
        if ($check !== false && in_array($check['mime'], $allowed_mime_types)) {
            $uploadOk = 1;
        } else {
            echo "File is not a valid image format.";
            $uploadOk = 0;
        }
    
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
    
        // Check file size (set to 5MB)
        if ($_FILES["product_image"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
    
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                $image = $target_file;
                $name = $_POST['name']; // Capture name
                $available_quantity = $_POST['available_quantity'];
                $price = $_POST['price'];
    
                // Now, store name in the database
                $this->list->addProductList($image, $available_quantity, $price, $name);
                header("Location: /product_list");
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    
    

    public function edit($product_list_id) {
        $list = $this->list->getProductListById($product_list_id);
        if ($list) {
            $this->view('products/edit_list', ['list' => $list]);
        } else {
            echo "Product not found.";
        }
    }

    public function update($product_list_id) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
    
        $image = $_FILES["product_image"]["name"] ? $target_dir . basename($_FILES["product_image"]["name"]) : null;
        $uploadOk = 1;
    
        if ($image) {
            $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    
            // Allowed image MIME types
            $allowed_mime_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp', 'image/tiff', 'image/svg+xml'];
    
            // Check if image file is valid
            $check = getimagesize($_FILES["product_image"]["tmp_name"]);
            if ($check !== false && in_array($check['mime'], $allowed_mime_types)) {
                $uploadOk = 1;
            } else {
                echo "File is not a valid image format.";
                $uploadOk = 0;
            }
    
            // Check if file already exists
            if (file_exists($image)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
    
            // Check file size (set to 5MB)
            if ($_FILES["product_image"]["size"] > 5000000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
    
            // Upload file if everything is OK
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            } else {
                if (!move_uploaded_file($_FILES["product_image"]["tmp_name"], $image)) {
                    echo "Sorry, there was an error uploading your file.";
                    return;
                }
            }
        }
    
        $name = $_POST['name']; // Capture name field
        $available_quantity = $_POST['available_quantity'];
        $price = $_POST['price'];
    
        $this->list->updateProductList($product_list_id, $image, $available_quantity, $price, $name);
        header("Location: /product_list");
    }

    public function search() {
        if (isset($_GET['name']) && !empty($_GET['name'])) {
            $name = $_GET['name'];
            $products = $this->list->searchProductByName($name);
            $this->view('products/product_list', ['product_list' => $products]);
        } else {
            header("Location: /product_list");
        }
    }
    
    
    

    // view detail of product list

    public function detail($product_list_id) {
        $list = $this->list->getProductListById($product_list_id);
        if ($list) {
            $this->view('products/detail_list', ['list' => $list]);
        } else {
            echo "Product not found.";
        }
    }
    public function destroy($product_list_id) {
        $this->list->deleteProductList($product_list_id);
        header("Location: /product_list");
    }
}
?>