<?php

class HrConfig
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function get($key)
    {
        $query = "SELECT value FROM hr_config WHERE config_key = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$key]);
        return $stmt->fetchColumn();
    }
}
