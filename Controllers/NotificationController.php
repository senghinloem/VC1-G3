<?php
require_once __DIR__ . "/../Models/NotificationModel.php";
require_once __DIR__ . "/BaseController.php";

class NotificationController extends BaseController {
    private $notificationModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->notificationModel = new NotificationModel(); // Fix: Use NotificationModel
    }

    // public function alert() {
    //     $this->checkAuthentication();

    //     $user_id = $_SESSION['user_id'];

    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         if (isset($_POST['mark_as_read'])) {
    //             $this->notificationModel->markAsRead($user_id);
    //             $_SESSION['success'] = 'All notifications marked as read';
    //             header("Location: /notification");
    //             exit();
    //         }
            
    //         if (isset($_POST['clear_all'])) {
    //             $this->notificationModel->clearAll($user_id);
    //             $_SESSION['success'] = 'All notifications cleared';
    //             header("Location: /notification");
    //             exit();
    //         }
    //     }

    //     $notifications = $this->notificationModel->getNotifications($user_id);
    //     $unread_count = $this->notificationModel->countUnread($user_id);

    //     $this->view('notification/notification', [
    //         'notifications' => $notifications,
    //         'unread_count' => $unread_count,
    //         'notificationTypes' => $this->notificationModel->getNotificationTypes()
    //     ]);
    // }

    public function check() {
        $this->checkAuthentication(true);
        
        $user_id = $_SESSION['user_id'];
        $unread_count = $this->notificationModel->countUnread($user_id);
        
        header('Content-Type: application/json');
        echo json_encode([
            'unread_count' => $unread_count,
            'success' => true
        ]);
        exit();
    }

    public function markAsRead($notification_id) {
        $this->checkAuthentication();
        
        if ($this->notificationModel->markSingleAsRead($notification_id, $_SESSION['user_id'])) {
            $_SESSION['success'] = 'Notification marked as read';
        } else {
            $_SESSION['error'] = 'Failed to mark notification as read';
        }
        
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    public function getUnread() {
        $this->checkAuthentication(true);
        
        $user_id = $_SESSION['user_id'];
        $notifications = $this->notificationModel->getNotifications($user_id, 5, true);
        
        header('Content-Type: application/json');
        echo json_encode([
            'notifications' => $notifications,
            'success' => true
        ]);
        exit();
    }

    private function checkAuthentication($json = false) {
        if (!isset($_SESSION['user_id'])) {
            if ($json) {
                header('HTTP/1.1 401 Unauthorized');
                echo json_encode(['error' => 'Unauthorized']);
                exit();
            }
            header("Location: /login");
            exit();
        }
    }

    public function alert() {
        $this->checkAuthentication();

        $user_id = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        }

        $notifications = $this->notificationModel->getNotifications($user_id);
        $unread_count = $this->notificationModel->countUnread($user_id);

        $this->view('notification/notification', [
            'notifications' => $notifications,
            'unread_count' => $unread_count,
            'notificationTypes' => $this->notificationModel->getNotificationTypes()
        ]);
    }


}