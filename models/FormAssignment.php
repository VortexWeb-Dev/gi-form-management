<?php

class FormAssignment
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $query = "
            SELECT 
                fa.*, 
                ft.title AS template_name
            FROM 
                form_assignments fa
            LEFT JOIN 
                form_templates ft ON fa.template_id = ft.id
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array
    {
        $query = "
            SELECT 
                fa.*,
                ft.title      AS template_name,
                ft.description AS template_description
            FROM 
                form_assignments fa
            LEFT JOIN 
                form_templates ft ON fa.template_id = ft.id
            WHERE 
                fa.id = ?
            LIMIT 1
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function getByUserId($userId)
    {
        $query = "
            SELECT 
                fa.*, 
                ft.title AS template_name
            FROM 
                form_assignments fa
            LEFT JOIN 
                form_templates ft ON fa.template_id = ft.id
            WHERE 
                fa.assigned_to = ?
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByHrId($hrId)
    {
        $query = "
            SELECT 
                fa.*, 
                ft.title AS template_name
            FROM 
                form_assignments fa
            LEFT JOIN 
                form_templates ft ON fa.template_id = ft.id
            WHERE 
                fa.assigned_by = ?
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$hrId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function approve($assignmentId)
    {
        $query = "UPDATE form_assignments SET status = 'approved' WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$assignmentId]);
    }

    public function reject($assignmentId)
    {
        $query = "UPDATE form_assignments SET status = 'rejected' WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$assignmentId]);
    }

    public function createAssignment($templateId, $assignedTo, $assignedBy, $remarks = null)
    {
        $query = "INSERT INTO form_assignments (template_id, assigned_to, assigned_by, status, remarks, assigned_at) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $assignedAt = date('Y-m-d H:i:s');

        return $stmt->execute([$templateId, $assignedTo, $assignedBy, 'pending', $remarks, $assignedAt]);
    }
}
