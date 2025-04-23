<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/AuditLog.php';

class LogController
{

    private $user;
    private $userMapping;

    public function __construct($user, $userMapping)
    {
        $this->user = $user;
        $this->userMapping = $userMapping;
    }

    public function index(): array
    {
        // DB Connection
        $database = new Database();
        $db = $database->getConnection();

        // Load model
        $auditLogModel = new AuditLog($db);

        $userId = $this->user['ID'];
        $logs = $auditLogModel->getAll($userId);
        foreach ($logs as &$log) {
            $log['user_name'] = $this->userMapping[$log['user_id']] ?? 'Unknown User';
        }

        return [
            'title' => 'Audit Log',
            'description' => 'View and manage the audit log.',
            'logs' => $logs,
        ];
    }
}
