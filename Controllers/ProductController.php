<?php

require_once "Models/ProductModel.php" ;

class ProductController extends BaseController
{

    private $product;

    public function __construct() {
        $this->product = new ProductModel();
        $stocks = $this->product->getAllStocks(); 
    }

public function product() {
    $products = $this->product->getAllProducts(true); // true to include stock info
    $stocks = $this->product->getAllStocks();
    $this->view('products/products', [
        'products' => $products,
        'stocks' => $stocks
    ]); 
}
    
    public function create() {
        $categories = $this->product->getAllCategories();
        $this->view('products/create', ['categories' => $categories]);
    }

    public function store() {
        $imagePath = "uploads/default.png"; 
        $errors = [];
    
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
                $_SESSION['uploaded_image'] = $imagePath;

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
        $category_id = (int)($_POST['category_id'] ?? 0);



        if (!$name) {
            $errors['name'] = "Product name is required.";
        }
        if (!$price || $price <= 0) {
            $errors['price'] = "Product price must be a positive number.";
        }
        if (!$quantity || $quantity < 0) {
            $errors['quantity'] = "Product quantity must be a non-negative integer.";
        }
        if ($category_id <= 0) {
            $errors['category_id'] = "Please select a category.";
        } else {
            $validCategories = array_column($this->product->getAllCategories(), 'category_id');
            if (!in_array($category_id, $validCategories)) {
                $errors['category_id'] = "Invalid category selected.";
            }
        }

        if (empty($errors)) {
            $this->product->addProduct(
                $imagePath, 
                $name, 
                $description, 
                $price, 
                $unit, 
                $quantity, 
                $category_id);

            header('Location: /products');
            exit();

        } else {
            $categories = $this->product->getAllCategories();
                $this->view('products/create', [
                'categories' => $categories,
                'errors' => $errors,
                'old' => $_POST
            ]);
        }


    }
    

    public function import() {
        // Set the Content-Type header to ensure the response is JSON
        header('Content-Type: application/json');

        try {
            // Get the JSON payload
            $inputData = json_decode(file_get_contents("php://input"), true);

            // Check if the JSON decoding was successful
            if (json_last_error() !== JSON_ERROR_NONE) {
                http_response_code(400);
                echo json_encode([
                    "success" => false,
                    "message" => "Invalid JSON: " . json_last_error_msg()
                ]);
                return;
            }

            // Validate the payload
            if (!isset($inputData['products']) || !is_array($inputData['products']) || empty($inputData['products'])) {
                http_response_code(400);
                echo json_encode([
                    "success" => false,
                    "message" => "Invalid data format: 'products' must be a non-empty array"
                ]);
                return;
            }

            // Look for a "Default" category, or create one if it doesn't exist
            $defaultCategory = $this->product->getDefaultCategory();
            if (!$defaultCategory) {
                // Create a "Default" category if it doesn't exist
                $this->product->createDefaultCategory();
                $defaultCategory = $this->product->getDefaultCategory();
                if (!$defaultCategory) {
                    http_response_code(500);
                    echo json_encode([
                        "success" => false,
                        "message" => "Failed to create or retrieve a default category."
                    ]);
                    return;
                }
            }
            $defaultCategoryId = $defaultCategory['category_id'];

            $importedCount = 0;
            $errors = [];

            // Process each product
            foreach ($inputData['products'] as $index => $product) {
                // Extract and validate product data
                $image = !empty($product['image']) ? $product['image'] : "uploads/default.png";
                $name = trim($product['name'] ?? '');
                $description = trim($product['description'] ?? '');
                $price = floatval($product['price'] ?? 0);
                $unit = trim($product['unit'] ?? '');
                $quantity = intval($product['quantity'] ?? 0);

                // Validate required fields
                if (empty($name)) {
                    $errors[] = "Row " . ($index + 2) . ": Product name is required.";
                    continue;
                }
                if ($price <= 0) {
                    $errors[] = "Row " . ($index + 2) . ": Product price must be a positive number.";
                    continue;
                }
                if ($quantity < 0) {
                    $errors[] = "Row " . ($index + 2) . ": Product quantity must be a non-negative integer.";
                    continue;
                }

                // Add the product to the database
                try {
                    $this->product->addProduct($image, $name, $description, $price, $unit, $quantity, $defaultCategoryId);
                    $importedCount++;
                } catch (Exception $e) {
                    $errors[] = "Row " . ($index + 2) . ": Failed to import product - " . $e->getMessage();
                }
            }

            // Prepare the response
            if ($importedCount > 0) {
                $response = [
                    "success" => true,
                    "message" => "Imported $importedCount product(s) successfully"
                ];
                if (!empty($errors)) {
                    $response["warnings"] = $errors;
                }
                echo json_encode($response);
            } else {
                http_response_code(400);
                echo json_encode([
                    "success" => false,
                    "message" => "No products were imported",
                    "errors" => $errors
                ]);
            }
        } catch (Exception $e) {
            // Handle any unexpected errors
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "An error occurred while importing products: " . $e->getMessage()
            ]);
        }
    }
    
    

    public function delete($product_id) {
        $this->product->deleteProduct($product_id);
        header("Location: /products");
    }

    // New method to delete multiple products
    public function deleteMultiple() {
        $inputData = json_decode(file_get_contents("php://input"), true);
        
        if (!isset($inputData['product_ids']) || !is_array($inputData['product_ids']) || empty($inputData['product_ids'])) {
            echo json_encode(["success" => false, "message" => "No products selected for deletion"]);
            return;
        }

        $this->product->deleteMultipleProducts($inputData['product_ids']);
        echo json_encode(["success" => true, "message" => "Selected products deleted successfully"]);
    }

    public function assignStock() {
        $inputData = json_decode(file_get_contents("php://input"), true);
        
        if (empty($inputData['product_ids']) || empty($inputData['stock_id'])) {
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
            
            echo json_encode([
                "success" => true,
                "message" => "Assigned {$successCount} products to stock"
            ]);
        } catch (Exception $e) {
            echo json_encode([
                "success" => false, 
                "message" => $e->getMessage()
            ]);
        }
    }
}

?>