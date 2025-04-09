<?php
require_once "Models/DashboardModel.php";
require_once "Models/NotificationModel.php";

class DashboardController extends BaseController
{
    private $product;
    private $notificationModel;

    public function __construct()
    {
        $this->product = new DashboardModel();
        $this->notificationModel = new NotificationModel();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function product()
    {
        $products = $this->product->getAllProducts();
        $this->view('dashboard/dashboard', ['products' => $products]);
    }

    public function dashboard()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $totalProducts = $this->product->getTotalProducts();
        $products = $this->product->getAllProducts(); 
        $totalQuantity = $this->product->getTotalQuantity(); 
        $totalPrice = $this->product->getTotalPrice(); 
        $totalLowStock = $this->product->getLowStockCount(); 
        $totalProductsPercentage = $this->product->getTotalProductsPercentage();
        $lowStockPercentage = $this->product->getLowStockPercentage();
        $lowStockProducts = $this->product->getLowStockProducts();

        // Check and create notifications for low stock products
        $this->checkAndNotifyLowStock($lowStockProducts, $_SESSION['user_id']);

        $this->view('dashboard/dashboard', [
            'products' => $products,
            'totalProducts' => $totalProducts,
            'totalQuantity' => $totalQuantity,
            'totalPrice' => $totalPrice,
            'totalLowStock' => $totalLowStock,
            'totalProductsPercentage' => $totalProductsPercentage,
            'lowStockPercentage' => $lowStockPercentage,
            'lowStockProducts' => $lowStockProducts
        ]);
    }

    private function checkAndNotifyLowStock($lowStockProducts, $userId)
    {
        // Get existing notifications to avoid duplicates
        $existingNotifications = $this->notificationModel->getAllUserNotifications($userId);
        $existingMessages = array_column($existingNotifications, 'message');

        foreach ($lowStockProducts as $product) {
            $message = "Low stock alert: Product '{$product['name']}' has only {$product['quantity']} units left!";
            
            // Only add notification if it doesn't already exist
            if (!in_array($message, $existingMessages)) {
                $this->notificationModel->addNotification(
                    $userId,
                    $message,
                    'warning'
                );
                error_log("Added low stock notification for product: {$product['name']}");
            }
        }
    }
}