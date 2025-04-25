<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Notification.php';

class NotificationsController
{

    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function index(): array
    {
        // DB Connection
        $database = new Database();
        $db = $database->getConnection();

        // Load model
        $notificationModel = new Notification($db);

        $userId = $this->user['ID'];
        $notifications = $notificationModel->getAll($userId);

        return [
            'title' => 'Notifications',
            'description' => 'View notifications and alerts.',
            'notifications' => $notifications,
        ];
    }

    public function markAllAsRead(): void
    {
        $database = new Database();
        $db = $database->getConnection();
        $notificationModel = new Notification($db);

        $userId = $this->user['ID'];
        $notificationModel->markAllAsRead($userId);
    }
}
