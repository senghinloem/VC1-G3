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
        // Check if the uploads directory exists, if not create it
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["product_image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["product_image"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                $image = $target_file;
                $available_quantity = $_POST['available_quantity'];
                $price = $_POST['price'];
                $this->list->addProductList($image, $available_quantity, $price);
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
        // Check if the uploads directory exists, if not create it
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $image = $_FILES["product_image"]["name"] ? $target_dir . basename($_FILES["product_image"]["name"]) : null;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));

        if ($image) {
            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["product_image"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }

            // Check if file already exists
            if (file_exists($image)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["product_image"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
            } else {
                if (!move_uploaded_file($_FILES["product_image"]["tmp_name"], $image)) {
                    echo "Sorry, there was an error uploading your file.";
                    return;
                }
            }
        }

        $available_quantity = $_POST['available_quantity'];
        $price = $_POST['price'];
        $this->list->updateProductList($product_list_id, $image, $available_quantity, $price);
        header("Location: /product_list");
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