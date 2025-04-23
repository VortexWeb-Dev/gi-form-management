<?php

class FormField
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getByTemplateId($templateId)
    {
        $query = "SELECT * FROM form_fields WHERE template_id = ? ORDER BY field_order";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$templateId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
