<?php
class NotificationModel {
    private $db;

    public function __construct() {
        $this->db = new Database("localhost", "vc1_db", "root", "");
    }

    public function addNotification($user_id, $message, $type = 'info') {
        $query = "INSERT INTO notifications (user_id, message, type, created_at) 
                 VALUES (:user_id, :message, :type, NOW())";
        try {
            $this->db->query($query, [
                ':user_id' => $user_id,
                ':message' => $message,
                ':type' => $type
            ]);
        } catch (Exception $e) {
            error_log("Error adding notification: " . $e->getMessage());
        }
    }

    public function getUserNotifications($user_id) {
        $query = "SELECT * FROM notifications 
                 WHERE user_id = :user_id 
                 AND is_read = 0 
                 ORDER BY created_at DESC 
                 LIMIT 10";
        try {
            return $this->db->query($query, [':user_id' => $user_id])->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching user notifications: " . $e->getMessage());
            return [];
        }
    }

    public function getAllUserNotifications($user_id) {
        $query = "SELECT * FROM notifications 
                 WHERE user_id = :user_id 
                 ORDER BY created_at DESC";
        try {
            return $this->db->query($query, [':user_id' => $user_id])->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching all user notifications: " . $e->getMessage());
            return [];
        }
    }

    public function getNotificationCount($user_id) {
        $query = "SELECT COUNT(*) as count FROM notifications 
                 WHERE user_id = :user_id AND is_read = 0";
        try {
            $result = $this->db->query($query, [':user_id' => $user_id])->fetch(PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            error_log("Error counting notifications: " . $e->getMessage());
            return 0;
        }
    }

    public function markAsRead($notification_id) {
        $query = "UPDATE notifications SET is_read = 1 WHERE notification_id = :notification_id"; // Changed 'id' to 'notification_id'
        try {
            $this->db->query($query, [':notification_id' => $notification_id]);
        } catch (Exception $e) {
            error_log("Error marking notification as read: " . $e->getMessage());
        }
    }

    public function markAllAsRead($user_id) {
        $query = "UPDATE notifications SET is_read = 1 WHERE user_id = :user_id AND is_read = 0";
        try {
            $this->db->query($query, [':user_id' => $user_id]);
        } catch (Exception $e) {
            error_log("Error marking all notifications as read: " . $e->getMessage());
        }
    }

    public function deleteNotification($notification_id) {
        $query = "DELETE FROM notifications WHERE notification_id = :notification_id"; // Changed 'id' to 'notification_id'
        try {
            $stmt = $this->db->query($query, [':notification_id' => $notification_id]);
            $rowCount = $stmt->rowCount();
            error_log("Deleted $rowCount notification(s) with ID: $notification_id");
            return $rowCount > 0;
        } catch (Exception $e) {
            error_log("Error deleting notification ID $notification_id: " . $e->getMessage());
            return false;
        }
    }
}
?>