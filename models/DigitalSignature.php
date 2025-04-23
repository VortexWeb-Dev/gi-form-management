<?php

class DigitalSignature
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getByAssignment($assignmentId)
    {
        $query = "SELECT * FROM digital_signatures WHERE assignment_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$assignmentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
