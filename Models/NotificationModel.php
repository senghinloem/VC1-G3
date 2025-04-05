<?php
require_once __DIR__ . "/../Database/Database.php";

class NotificationModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database("localhost", "vc1_db", "root", "");
    }

    // Existing method for user-specific notifications
    public function getNotifications($user_id, $limit = null, $unread_only = false)
    {
        $query = "SELECT * FROM notifications WHERE user_id = :user_id";
        if ($unread_only) {
            $query .= " AND is_read = 0";
        }
        $query .= " ORDER BY created_at DESC";
        if ($limit) {
            $query .= " LIMIT :limit";
        }

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        if ($limit) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // New method for system-wide notifications
    public function getSystemNotifications()
    {
        $query = "SELECT * FROM notifications WHERE user_id IS NULL OR type IN ('system_event', 'other_action') ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countUnread($user_id)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = :user_id AND is_read = 0");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function markAsRead($user_id)
    {
        $stmt = $this->db->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = :user_id AND is_read = 0");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function clearAll($user_id)
    {
        $stmt = $this->db->prepare("DELETE FROM notifications WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function markSingleAsRead($notification_id, $user_id)
    {
        $stmt = $this->db->prepare("UPDATE notifications SET is_read = 1 WHERE notification_id = :id AND user_id = :user_id");
        $stmt->bindParam(':id', $notification_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function getNotificationTypes()
    {
        return [
            'stock_created' => ['color' => 'success', 'icon' => 'bi-box-seam'],
            'low_stock' => ['color' => 'warning', 'icon' => 'bi-exclamation-triangle'],
            'system_event' => ['color' => 'info', 'icon' => 'bi-gear'],
            'other_action' => ['color' => 'secondary', 'icon' => 'bi-person']
        ];
    }
}