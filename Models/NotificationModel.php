<?php
require_once "Database/Database.php";

class NotificationModel {
    private $db;

    public function __construct() {
        $this->db = new Database("localhost", "vc1_db", "root", "");
    }

    // public function getNotifications($user_id, $limit = 20, $unread_only = false) {
    //     $sql = "SELECT * FROM notifications WHERE user_id = ?";
    //     if ($unread_only) {
    //         $sql .= " AND is_read = 0";
    //     }
    //     $sql .= " ORDER BY is_read ASC, created_at DESC LIMIT ?";
    //     $stmt = $this->db->prepare($sql);
    //     $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
    //     $stmt->bindValue(2, $limit, PDO::PARAM_INT);
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    // public function countUnread($user_id) {
    //     $sql = "SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0";
    //     $stmt = $this->db->prepare($sql);
    //     $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
    //     $stmt->execute();
    //     return $stmt->fetchColumn();
    // }

    // public function markAsRead($user_id) {
    //     $sql = "UPDATE notifications SET is_read = 1 WHERE user_id = ? AND is_read = 0";
    //     $stmt = $this->db->prepare($sql);
    //     $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
    //     return $stmt->execute();
    // }

    // public function markSingleAsRead($notification_id, $user_id) {
    //     $sql = "UPDATE notifications SET is_read = 1 WHERE notification_id = ? AND user_id = ?";
    //     $stmt = $this->db->prepare($sql);
    //     $stmt->bindValue(1, $notification_id, PDO::PARAM_INT);
    //     $stmt->bindValue(2, $user_id, PDO::PARAM_INT);
    //     return $stmt->execute();
    // }

    public function clearAll($user_id) {
        $sql = "DELETE FROM notifications WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function logAction($user_id, $message, $type = 'info', $link = null) {
        $sql = "INSERT INTO notifications (user_id, message, type, link) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
        $stmt->bindValue(2, $message, PDO::PARAM_STR);
        $stmt->bindValue(3, $type, PDO::PARAM_STR);
        $stmt->bindValue(4, $link, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function getNotificationTypes() {
        return [
            'info' => ['icon' => 'bi-info-circle', 'color' => 'info'],
            'success' => ['icon' => 'bi-check-circle', 'color' => 'success'],
            'warning' => ['icon' => 'bi-exclamation-triangle', 'color' => 'warning'],
            'danger' => ['icon' => 'bi-x-circle', 'color' => 'danger']
        ];
    }

    public function getNotifications($user_id, $limit = 10)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM notifications 
            WHERE user_id = :user_id 
            ORDER BY created_at DESC 
            LIMIT :limit
        ");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countUnread($user_id)
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM notifications 
            WHERE user_id = :user_id AND is_read = 0
        ");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function markSingleAsRead($notification_id, $user_id)
    {
        $stmt = $this->db->prepare("
            UPDATE notifications 
            SET is_read = 1 
            WHERE notification_id = :id AND user_id = :user_id
        ");
        $stmt->bindParam(':id', $notification_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function markAsRead($user_id)
    {
        $stmt = $this->db->prepare("
            UPDATE notifications 
            SET is_read = 1 
            WHERE user_id = :user_id AND is_read = 0
        ");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}