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
        $image = $this->handleImageUpload();
        if (!$image) return; // Stop if upload fails

        $name = $_POST['name'];
        $available_quantity = $_POST['available_quantity'];
        $price = $_POST['price'];

        $this->list->addProductList($image, $name, $available_quantity, $price);
        header("Location: /product_list");
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
        $list = $this->list->getProductListById($product_list_id);
        if (!$list) {
            echo "Product not found.";
            return;
        }

        $image = $this->handleImageUpload() ?: $list['image']; // Keep old image if no new one is uploaded
        $name = $_POST['name'];
        $available_quantity = $_POST['available_quantity'];
        $price = $_POST['price'];

        $this->list->updateProductList($product_list_id, $image, $name, $available_quantity, $price);
        header("Location: /product_list");
    }

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

    private function handleImageUpload() {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        if (!isset($_FILES["product_image"]) || $_FILES["product_image"]["error"] != 0) {
            return null; // No file uploaded
        }

        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed_mime_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp', 'image/tiff', 'image/svg+xml'];
        $check = getimagesize($_FILES["product_image"]["tmp_name"]);

        if (!$check || !in_array($check['mime'], $allowed_mime_types)) {
            echo "File is not a valid image format.";
            return null;
        }

        if ($_FILES["product_image"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            return null;
        }

        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            return null;
        }

        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            return $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
            return null;
        }
    }

    public function search() {
        $searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';
        $list = $this->list->searchProductByName($searchQuery);
        $this->view('products/product_list', ['product_list' => $list, 'searchQuery' => $searchQuery]);
    }
}
?>
