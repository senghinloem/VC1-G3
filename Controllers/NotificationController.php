<?php
require_once __DIR__ . "/../Models/NotificationModel.php";
require_once __DIR__ . "/BaseController.php";

class NotificationController extends BaseController
{
    private $notificationModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->notificationModel = new NotificationModel();
    }

    private function checkAuthentication($ajax = false)
    {
        if (!isset($_SESSION['user_id'])) {
            if ($ajax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Unauthorized']);
                exit();
            } else {
                header("Location: /login?error=Please login to continue");
                exit();
            }
        }
    }

    public function index()
    {
        $this->checkAuthentication();
        try {
            $user_id = $_SESSION['user_id'];
            // Fetch user-specific and system-wide notifications
            $user_notifications = $this->notificationModel->getNotifications($user_id);
            $system_notifications = $this->notificationModel->getSystemNotifications(); // New method
            $all_notifications = array_merge($user_notifications, $system_notifications);

            $this->view('notification/notification', [
                'notifications' => $all_notifications,
                'notificationTypes' => $this->notificationModel->getNotificationTypes()
            ]);
        } catch (Exception $e) {
            error_log("Error fetching notifications: " . $e->getMessage());
            $this->redirect('/notification?error=Failed to load notifications');
        }
    }

    public function alert()
    {
        $this->checkAuthentication();
        $user_id = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if (isset($_POST['mark_as_read'])) {
                    $this->notificationModel->markAsRead($user_id);
                    $_SESSION['success'] = 'All notifications marked as read';
                    header("Location: /notification");
                    exit();
                }
                
                if (isset($_POST['clear_all'])) {
                    $this->notificationModel->clearAll($user_id);
                    $_SESSION['success'] = 'All notifications cleared';
                    header("Location: /notification");
                    exit();
                }
            } catch (Exception $e) {
                error_log("Error processing alert action: " . $e->getMessage());
                $_SESSION['error'] = 'Failed to process action';
            }
        }

        try {
            $user_notifications = $this->notificationModel->getNotifications($user_id);
            $system_notifications = $this->notificationModel->getSystemNotifications(); // New method
            $all_notifications = array_merge($user_notifications, $system_notifications);
            $unread_count = $this->notificationModel->countUnread($user_id);

            $this->view('notification/notification', [
                'notifications' => $all_notifications,
                'unread_count' => $unread_count,
                'notificationTypes' => $this->notificationModel->getNotificationTypes()
            ]);
        } catch (Exception $e) {
            error_log("Error fetching alert data: " . $e->getMessage());
            $this->redirect('/notification?error=Failed to load notifications');
        }
    }

    public function check()
    {
        $this->checkAuthentication(true);
        try {
            $user_id = $_SESSION['user_id'];
            $unread_count = $this->notificationModel->countUnread($user_id);
            
            header('Content-Type: application/json');
            echo json_encode([
                'unread_count' => $unread_count,
                'success' => true
            ]);
        } catch (Exception $e) {
            error_log("Error checking notifications: " . $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Error checking notifications'
            ]);
        }
        exit();
    }

    public function markAsRead($notification_id)
    {
        $this->checkAuthentication();
        
        try {
            if ($this->notificationModel->markSingleAsRead($notification_id, $_SESSION['user_id'])) {
                $_SESSION['success'] = 'Notification marked as read';
            } else {
                $_SESSION['error'] = 'Failed to mark notification as read';
            }
        } catch (Exception $e) {
            error_log("Error marking notification as read: " . $e->getMessage());
            $_SESSION['error'] = 'Error processing request';
        }
        
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?: '/notification'));
        exit();
    }
}