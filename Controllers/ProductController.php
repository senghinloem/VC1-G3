<?php
require_once "Models/ProductModel.php";
require_once "Models/NotificationModel.php";

class ProductController extends BaseController {
    private $product;
    private $notification;

    public function __construct() {
        $this->product = new ProductModel();
        $this->notification = new NotificationModel();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function product() {
        $products = $this->product->getAllProducts(true);
        $stocks = $this->product->getAllStocks();
        $this->view('products/products', [
            'products' => $products,
            'stocks' => $stocks
        ]);
    }

    public function create() {
        $this->view('products/create');
    }

    public function store() {
        $imagePath = 'https://www.mooreseal.com/wp-content/uploads/2013/11/dummy-image-square.jpg';
        $errors = [];

        if (!empty($_FILES['image']['name'])) {
            $imageInfo = getimagesize($_FILES['image']['tmp_name']);
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if ($imageInfo && in_array($imageInfo['mime'], $allowedTypes)) {
                $uploadDir = "uploads/";
                $imageName = time() . "_" . basename($_FILES['image']['name']);
                $imagePath = $uploadDir . preg_replace("/[^a-zA-Z0-9.\-_]/", "", $imageName);
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                    $this->notification->addNotification(
                        $_SESSION['user_id'],
                        "Failed to upload product image",
                        'error'
                    );
                    die("Error uploading the file.");
                }
                $_SESSION['uploaded_image'] = $imagePath;
            } else {
                $this->notification->addNotification(
                    $_SESSION['user_id'],
                    "Invalid image file type uploaded",
                    'error'
                );
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

        if (!$name) {
            $errors['name'] = "Product name is required.";
        }
        if (!$price || $price <= 0) {
            $errors['price'] = "Product price must be a positive number.";
        }
        if (!$quantity || $quantity < 0) {
            $errors['quantity'] = "Product quantity must be a non-negative integer.";
        }

        if (empty($errors)) {
            try {
                $this->product->addProduct($imagePath, $name, $description, $price, $unit, $quantity);
                $this->notification->addNotification(
                    $_SESSION['user_id'],
                    "New product '$name' added",
                    'success'
                );
                header('Location: /products');
                exit();
            } catch (PDOException $e) {
                $this->notification->addNotification(
                    $_SESSION['user_id'],
                    "Failed to add product '$name': " . $e->getMessage(),
                    'error'
                );
                echo "Error adding product: " . $e->getMessage();
            }
        } else {
            $this->notification->addNotification(
                $_SESSION['user_id'],
                "Product creation failed: " . implode(", ", $errors),
                'error'
            );
            $this->view('products/create', [
                'errors' => $errors,
                'old' => $_POST
            ]);
        }
    }

    public function import() {
        $inputData = json_decode(file_get_contents("php://input"), true);
        if (!isset($inputData['products']) || !is_array($inputData['products'])) {
            $this->notification->addNotification(
                $_SESSION['user_id'],
                "Product import failed: Invalid data format",
                'error'
            );
            echo json_encode(["success" => false, "message" => "Invalid data format"]);
            return;
        }

        $successCount = 0;
        foreach ($inputData['products'] as $product) {
            $image = !empty($product['image']) ? $product['image'] : "uploads/default.png";
            $name = $product['name'];
            $description = $product['description'];
            $price = floatval($product['price']);
            $unit = $product['unit'];
            $quantity = intval($product['quantity']);
            try {
                $this->product->addProduct($image, $name, $description, $price, $unit, $quantity);
                $successCount++;
            } catch (PDOException $e) {
                $this->notification->addNotification(
                    $_SESSION['user_id'],
                    "Failed to import product '$name': " . $e->getMessage(),
                    'error'
                );
            }
        }
        $this->notification->addNotification(
            $_SESSION['user_id'],
            "Imported $successCount products successfully",
            'success'
        );
        echo json_encode(["success" => true, "message" => "Products imported successfully"]);
    }

    public function deleteMultiple() {
        $inputData = json_decode(file_get_contents("php://input"), true);
        if (!isset($inputData['product_ids']) || !is_array($inputData['product_ids']) || empty($inputData['product_ids'])) {
            $this->notification->addNotification(
                $_SESSION['user_id'],
                "Product deletion failed: No products selected",
                'error'
            );
            echo json_encode(["success" => false, "message" => "No products selected for deletion"]);
            return;
        }

        try {
            $this->product->deleteMultipleProducts($inputData['product_ids']);
            $this->notification->addNotification(
                $_SESSION['user_id'],
                "Deleted " . count($inputData['product_ids']) . " products",
                'success'
            );
            echo json_encode(["success" => true, "message" => "Selected products deleted successfully"]);
        } catch (PDOException $e) {
            $this->notification->addNotification(
                $_SESSION['user_id'],
                "Failed to delete products: " . $e->getMessage(),
                'error'
            );
            echo json_encode(["success" => false, "message" => "Error deleting products: " . $e->getMessage()]);
        }
    }

    public function assignStock() {
        $inputData = json_decode(file_get_contents("php://input"), true);
        if (empty($inputData['product_ids']) || empty($inputData['stock_id'])) {
            $this->notification->addNotification(
                $_SESSION['user_id'],
                "Stock assignment failed: Invalid data",
                'error'
            );
            echo json_encode(["success" => false, "message" => "Invalid data"]);
            return;
        }

        try {
            $successCount = 0;
            foreach ($inputData['product_ids'] as $productId) {
                if ($this->product->assignProductToStock($productId, $inputData['stock_id'])) {
                    $successCount++;
                }
            }
            $this->notification->addNotification(
                $_SESSION['user_id'],
                "Assigned $successCount products to stock",
                'success'
            );
            echo json_encode([
                "success" => true,
                "message" => "Assigned {$successCount} products to stock"
            ]);
        } catch (Exception $e) {
            $this->notification->addNotification(
                $_SESSION['user_id'],
                "Failed to assign stock: " . $e->getMessage(),
                'error'
            );
            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }
}
?>