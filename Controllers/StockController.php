<?php
require_once "Models/StockModel.php";
require_once "Models/NotificationModel.php";

class StockController extends BaseController {
    private $stockModel;
    private $notification;

    public function __construct() {
        $this->stockModel = new StockModel();
        $this->notification = new NotificationModel();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function stock() {
        $stock_management = $this->stockModel->getStock();
        $this->view("stocks/stock", ["stock_management" => $stock_management]);
    }

    public function create_stock() {
        $this->view("stocks/create_stock");
    }

    public function view_detail($stock_id) {
        $stock = $this->stockModel->getStockById($stock_id);
        if ($stock) {
            $this->view('stocks/view_stock', ['stock' => $stock]);
        } else {
            $this->notification->addNotification(
                $_SESSION['user_id'],
                "Stock with ID $stock_id not found",
                'error'
            );
            $this->redirect('/stock?error=Stock not found');
        }
    }

    public function store() {
        if (!isset($_POST['stock_name']) || empty(trim($_POST['stock_name']))) {
            $this->notification->addNotification(
                $_SESSION['user_id'],
                "Stock creation failed: Stock name is required",
                'error'
            );
            $this->view("stocks/create_stock", ['error' => 'Stock name is required.']);
            return;
        }

        if (!isset($_POST['quantity']) || !is_numeric($_POST['quantity'])) {
            $this->notification->addNotification(
                $_SESSION['user_id'],
                "Stock creation failed: Valid quantity is required",
                'error'
            );
            $this->view("stocks/create_stock", ['error' => 'Valid quantity is required.']);
            return;
        }

        $stock_name = trim($_POST['stock_name']);
        $quantity = (int)$_POST['quantity'];

        try {
            $this->stockModel->addStock($stock_name, $quantity);
            $this->notification->addNotification(
                $_SESSION['user_id'],
                "New stock '$stock_name' added with quantity $quantity",
                'success'
            );
            $this->redirect('/stock?success=Stock added successfully');
        } catch (PDOException $e) {
            $this->notification->addNotification(
                $_SESSION['user_id'],
                "Failed to add stock '$stock_name': " . $e->getMessage(),
                'error'
            );
            if ($e->getCode() == '23000') {
                $this->view("stocks/create_stock", ['error' => 'Stock already created.']);
            } else {
                $this->view("stocks/create_stock", ['error' => 'An error occurred while creating stock: ' . $e->getMessage()]);
            }
        }
    }

    public function destroy($stock_id) {
        try {
            $stock = $this->stockModel->getStockById($stock_id);
            $stock_name = $stock['stock_name'] ?? "Unknown";
            $success = $this->stockModel->deleteStock($stock_id);
            if ($success) {
                $this->notification->addNotification(
                    $_SESSION['user_id'],
                    "Stock '$stock_name' deleted",
                    'success'
                );
                $this->redirect('/stock?success=Stock deleted successfully');
            } else {
                $this->notification->addNotification(
                    $_SESSION['user_id'],
                    "Stock with ID $stock_id not found",
                    'error'
                );
                $this->redirect('/stock?error=Stock not found');
            }
        } catch (Exception $e) {
            $this->notification->addNotification(
                $_SESSION['user_id'],
                "Failed to delete stock: " . $e->getMessage(),
                'error'
            );
            error_log("Delete error: " . $e->getMessage());
            $this->redirect('/stock?error=Failed to delete stock');
        }
    }

    public function search() {
        $search_term = $_GET['search'] ?? '';
        $stock_management = $this->stockModel->searchStock($search_term);
        $this->view("stocks/stock", ["stock_management" => $stock_management]);
    }

    public function edit($stock_id) {
        $stock = $this->stockModel->getStockById($stock_id);
        if ($stock) {
            $this->view('stocks/edit', ['stock' => $stock]);
        } else {
            $this->notification->addNotification(
                $_SESSION['user_id'],
                "Stock with ID $stock_id not found for editing",
                'error'
            );
            $this->redirect('/stock?error=Stock not found');
        }
    }

    public function update($stock_id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->notification->addNotification(
                $_SESSION['user_id'],
                "Invalid request method for updating stock ID $stock_id",
                'error'
            );
            $this->redirect('/stock/edit/' . $stock_id);
            return;
        }

        if (!isset($_POST['stock_name']) || empty(trim($_POST['stock_name']))) {
            $this->notification->addNotification(
                $_SESSION['user_id'],
                "Stock update failed: Stock name is required",
                'error'
            );
            $stock = $this->stockModel->getStockById($stock_id);
            $this->view("stocks/edit", [
                'error' => 'Stock name is required.',
                'stock' => $stock ?? ['stock_id' => $stock_id]
            ]);
            return;
        }

        if (!isset($_POST['quantity']) || !is_numeric($_POST['quantity'])) {
            $this->notification->addNotification(
                $_SESSION['user_id'],
                "Stock update failed: Valid quantity is required",
                'error'
            );
            $stock = $this->stockModel->getStockById($stock_id);
            $this->view("stocks/edit", [
                'error' => 'Valid quantity is required.',
                'stock' => $stock ?? ['stock_id' => $stock_id]
            ]);
            return;
        }

        $stock_name = trim($_POST['stock_name']);
        $quantity = (int)$_POST['quantity'];

        try {
            $success = $this->stockModel->updateStock($stock_id, $stock_name, $quantity);
            if ($success) {
                $this->notification->addNotification(
                    $_SESSION['user_id'],
                    "Stock '$stock_name' updated",
                    'success'
                );
                $this->redirect('/stock?success=Stock updated successfully');
            } else {
                throw new Exception("Update failed");
            }
        } catch (Exception $e) {
            $this->notification->addNotification(
                $_SESSION['user_id'],
                "Failed to update stock '$stock_name': " . $e->getMessage(),
                'error'
            );
            $this->view("stocks/edit", [
                'error' => 'An error occurred while updating the stock item.',
                'stock' => [
                    'stock_id' => $stock_id,
                    'stock_name' => $stock_name,
                    'quantity' => $quantity
                ]
            ]);
        }
    }
}
?>