<?php
// models/Notification.php

class Notification
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll($userId)
    {
        $query = "SELECT * FROM notifications WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUnread($userId)
    {
        $query = "SELECT * FROM notifications WHERE user_id = ? AND is_read = 0";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRead($userId)
    {
        $query = "SELECT * FROM notifications WHERE user_id = ? AND is_read = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function markAllAsRead($userId)
    {
        $query = "UPDATE notifications SET is_read = 1 WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$userId]);
    }

    /**
     * Create a new notification.
     *
     * @param int    $userId
     * @param int    $assignmentId
     * @param string $type
     * @param string $message
     * @return bool
     */
    public function create(int $userId, int $assignmentId, string $type, string $message): bool
    {
        $query = "
            INSERT INTO notifications
                (user_id, assignment_id, type, message, created_at)
            VALUES
                (?, ?, ?, ?, NOW())
        ";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $userId,
            $assignmentId,
            $type,
            $message,
        ]);
    }
}
