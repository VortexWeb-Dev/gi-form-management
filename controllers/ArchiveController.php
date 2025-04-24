<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/FormAssignment.php';

class ArchiveController
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

        $assignments = $formAssignmentModel->getByUserId($this->user['ID']);
        foreach ($assignments as &$assignment) {
            $assignment['assigned_to'] = $this->userMapping[$assignment['assigned_to']] ?? 'Unknown User';
            $assignment['assigned_by'] = $this->userMapping[$assignment['assigned_by']] ?? 'Unknown User';
        }
        // Filter assignments to only include those that are not submitted
        $assignments = array_filter($assignments, function ($assignment) {
            return strtolower($assignment['status']) === 'approved' || strtolower($assignment['status']) === 'rejected';
        });

        return [
            'title' => 'Archive',
            'description' => 'View and manage archived forms.',
            'assignments' => $assignments,
        ];
    }
}
