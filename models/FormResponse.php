<?php
// models/FormResponse.php

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

    /**
     * Save one field response.
     */
    public function create(int $assignmentId, int $fieldId, string $value): bool
    {
        $query = "
            INSERT INTO form_responses
                (assignment_id, field_id, response_value)
            VALUES
                (?, ?, ?)
        ";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $assignmentId,
            $fieldId,
            $value,
        ]);
    }
}
