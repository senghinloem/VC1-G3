<?php
require_once "BaseController.php";
require_once "Models/ProductListModel.php";
require_once "Models/NotificationModel.php";

class ProductListController extends BaseController {
    private $list;
    private $notification;

    public function __construct() {
        $this->list = new ProductListModel();
        $this->notification = new NotificationModel();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function product_list() {
        $stockList = $this->list->getProductStockList();
        $this->view('products/product_list', [
            'products' => $stockList,
            'searchQuery' => ''
        ]);
    }

    public function search() {
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                 strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        $searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';
        $products = (!empty($searchQuery)) ? 
            $this->list->searchProductByName($searchQuery) : 
            $this->list->getProductStockList();

        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['products' => $products]);
            exit;
        }

        $this->view('products/product_list', [
            'products' => $products,
            'searchQuery' => $searchQuery
        ]);
    }

    public function edit($product_id) {
        $products = $this->list->getProductListById($product_id);
        if (empty($products)) {
            $this->notification->addNotification(
                $_SESSION['user_id'],
                "Product with ID $product_id not found for editing",
                'error'
            );
            $_SESSION['error'] = "Product not found";
            header("Location: /product_list");
            exit;
        }
        $product = $products[0];
        $this->view('products/edit_list', ['product' => $product]);
    }

    public function update($product_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name');
            $description = filter_input(INPUT_POST, 'description');
            $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $unit = filter_input(INPUT_POST, 'unit');

            if (empty($name) || empty($price) || empty($unit)) {
                $this->notification->addNotification(
                    $_SESSION['user_id'],
                    "Product update failed: Required fields missing",
                    'error'
                );
                $_SESSION['error'] = "Please fill in all required fields";
                $this->view('products/product_edit', [
                    'product' => $this->list->getProductListById($product_id)[0]
                ]);
                return;
            }

            try {
                $result = $this->list->updateProduct($product_id, $name, $description, $price, $unit);
                if ($result) {
                    $this->notification->addNotification(
                        $_SESSION['user_id'],
                        "Product '$name' updated",
                        'success'
                    );
                    $_SESSION['success'] = "Product updated successfully";
                    header("Location: /product_list");
                    exit;
                } else {
                    $this->notification->addNotification(
                        $_SESSION['user_id'],
                        "Failed to update product with ID $product_id",
                        'error'
                    );
                    $_SESSION['error'] = "Failed to update product";
                }
            } catch (Exception $e) {
                $this->notification->addNotification(
                    $_SESSION['user_id'],
                    "Error updating product: " . $e->getMessage(),
                    'error'
                );
                $_SESSION['error'] = "Error updating product: " . $e->getMessage();
            }
        }
        $this->edit($product_id);
    }

    public function destroy($product_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $products = $this->list->getProductListById($product_id);
                if (empty($products)) {
                    $this->notification->addNotification(
                        $_SESSION['user_id'],
                        "Product with ID $product_id not found for deletion",
                        'error'
                    );
                    $_SESSION['error'] = "Product not found";
                    header("Location: /product_list");
                    exit;
                }
                $product_name = $products[0]['product_name'];
                $result = $this->list->deleteProduct($product_id);
                if ($result) {
                    $this->notification->addNotification(
                        $_SESSION['user_id'],
                        "Product '$product_name' deleted",
                        'success'
                    );
                    $_SESSION['success'] = "Product deleted successfully";
                } else {
                    $this->notification->addNotification(
                        $_SESSION['user_id'],
                        "Failed to delete product with ID $product_id",
                        'error'
                    );
                    $_SESSION['error'] = "Failed to delete product";
                }
            } catch (Exception $e) {
                $this->notification->addNotification(
                    $_SESSION['user_id'],
                    "Error deleting product: " . $e->getMessage(),
                    'error'
                );
                $_SESSION['error'] = "Error deleting product: " . $e->getMessage();
            }
            header("Location: /product_list");
            exit;
        }
        header("Location: /product_list");
        exit;
    }
}
?>