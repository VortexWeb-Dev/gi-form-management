<?php

class FormAssignment
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getByUserId($userId)
    {
        $query = "SELECT * FROM form_assignments WHERE assigned_to = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
