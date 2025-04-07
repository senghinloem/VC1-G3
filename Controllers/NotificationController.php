<?php
require_once "BaseController.php";
require_once "Models/NotificationModel.php";

class NotificationController extends BaseController {
    private $notificationModel;

    public function __construct() {
        $this->notificationModel = new NotificationModel();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index() {
        error_log("NotificationController::index called");
        if (!isset($_SESSION['user_id'])) {
            error_log("User not logged in, redirecting to /login");
            header("Location: /login");
            exit();
        }
        $notifications = $this->notificationModel->getAllUserNotifications($_SESSION['user_id']);
        error_log("Notifications fetched: " . json_encode($notifications));
        $this->view('notifications/notifications', [
            'notifications' => $notifications
        ]);
    }

    public function markAllAsRead() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("NotificationController::markAllAsRead called");
            if (!isset($_SESSION['user_id'])) {
                error_log("User not logged in, redirecting to /login");
                header("Location: /login");
                exit();
            }
            $this->notificationModel->markAllAsRead($_SESSION['user_id']);
            $this->notificationModel->addNotification(
                $_SESSION['user_id'],
                "All notifications marked as read",
                'success'
            );
            header("Location: /notifications");
            exit();
        }
    }

    public function markAsRead($notification_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("NotificationController::markAsRead called for ID: $notification_id");
            if (!isset($_SESSION['user_id'])) {
                error_log("User not logged in, redirecting to /login");
                header("Location: /login");
                exit();
            }
            $this->notificationModel->markAsRead($notification_id);
            $this->notificationModel->addNotification(
                $_SESSION['user_id'],
                "Notification marked as read",
                'success'
            );
            header("Location: /notifications");
            exit();
        }
    }

    public function delete($notification_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("NotificationController::delete called for ID: $notification_id");
            if (!isset($_SESSION['user_id'])) {
                error_log("User not logged in, redirecting to /login");
                header("Location: /login");
                exit();
            }
            // Verify the notification exists and belongs to the user
            $notifications = $this->notificationModel->getAllUserNotifications($_SESSION['user_id']);
            $notificationExists = false;
            foreach ($notifications as $notif) {
                if (isset($notif['notification_id']) && $notif['notification_id'] == $notification_id) { // Changed 'id' to 'notification_id'
                    $notificationExists = true;
                    break;
                }
            }
            if ($notificationExists) {
                $this->notificationModel->deleteNotification($notification_id);
                $this->notificationModel->addNotification(
                    $_SESSION['user_id'],
                    "Notification deleted",
                    'success'
                );
                error_log("Notification ID $notification_id deleted successfully");
            } else {
                error_log("Notification ID $notification_id not found for user {$_SESSION['user_id']}");
            }
            header("Location: /notifications");
            exit();
        } else {
            error_log("Invalid request method for delete: " . $_SERVER['REQUEST_METHOD']);
            header("Location: /notifications");
            exit();
        }
    }
}
?>