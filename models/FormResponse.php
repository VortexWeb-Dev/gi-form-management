<?php

class FormResponse
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getByAssignment($assignmentId)
    {
        $query = "SELECT * FROM form_responses WHERE assignment_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$assignmentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
