<?php

class FormTemplate
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $query = "SELECT * FROM form_templates";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllWithFields()
    {
        $query = "SELECT ft.*, f.label, f.type, f.is_required, f.field_order, f.placeholder FROM form_templates ft
                  LEFT JOIN form_fields f ON ft.id = f.template_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
