<?php

class AuditLog
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function addLog($action, $userId, $targetId, $context, $details)
    {
        $query = "INSERT INTO audit_logs (action, user_id, target_id, context, details, timestamp)
                  VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$action, $userId, $targetId, $context, $details]);
    }

    public function getAll($userId)
    {
        $query = "SELECT * FROM audit_logs WHERE user_id = ? ORDER BY timestamp DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
