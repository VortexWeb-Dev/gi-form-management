<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/FormAssignment.php';
require_once __DIR__ . '/../models/Notification.php';

class DashboardController
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
        $formAssignmentModel = new FormAssignment($db);
        $notificationModel = new Notification($db);

        $notifications = $notificationModel->getAll($this->user['ID']);
        // Take the first 3 notifications
        $notifications = array_slice($notifications, 0, 3);

        $assignments = $formAssignmentModel->getByHrId($this->user['ID']);
        foreach ($assignments as &$assignment) {
            $assignment['assigned_to'] = $this->userMapping[$assignment['assigned_to']] ?? 'Unknown User';
            $assignment['assigned_by'] = $this->userMapping[$assignment['assigned_by']] ?? 'Unknown User';
        }
        // Filter assignments to only include those that are not approved or rejected
        $pendingAssignments = array_filter($assignments, function ($assignment) {
            return strtolower($assignment['status']) !== 'approved' && strtolower($assignment['status']) !== 'rejected';
        });
        $submittedAssignments = array_filter($assignments, function ($assignment) {
            return strtolower($assignment['status']) === 'submitted';
        });
        $approvedAssignments = array_filter($assignments, function ($assignment) {
            return strtolower($assignment['status']) === 'approved';
        });
        $rejectedAssignments = array_filter($assignments, function ($assignment) {
            return strtolower($assignment['status']) === 'rejected';
        });

        return [
            'title' => 'Dashboard',
            'description' => 'Overview of recent activity, pending approvals, and quick actions.',
            'cards' => [
                ['label' => 'Pending Approvals', 'value' => count($pendingAssignments), 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                ['label' => 'Submitted Forms', 'value' => count($submittedAssignments), 'bg' => 'bg-green-100', 'text' => 'text-green-800'],
                ['label' => 'Approved Forms', 'value' => count($approvedAssignments), 'bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                ['label' => 'Rejected Forms', 'value' => count($rejectedAssignments), 'bg' => 'bg-red-100', 'text' => 'text-red-800'],
            ],
            'quickLinks' => [
                [
                    'label' => 'Send a Form',
                    'link' => '?page=send'
                ],
                [
                    'label' => 'Track Signatures',
                    'link' => '?page=track'
                ],
                [
                    'label' => 'View Archive',
                    'link' => '?page=archive'
                ],
                [
                    'label' => 'Manage Templates',
                    'link' => '?page=templates'
                ],
                [
                    'label' => 'Assign HR Roles',
                    'link' => '?page=config'
                ],
                [
                    'label' => 'View Audit Logs',
                    'link' => '?page=log'
                ],
            ],
            'pendingAssignments' => $pendingAssignments,
            'notifications' => $notifications,
        ];
    }
}
