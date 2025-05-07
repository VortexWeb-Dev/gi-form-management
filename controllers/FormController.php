<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/FormAssignment.php';

class FormController
{
    private $user;
    private $userMapping;

    public function __construct($user, $userMapping)
    {
        $this->user        = $user;
        $this->userMapping = $userMapping;
    }

    /**
     * Show the “view assignment” page.
     */
    public function view(): array
    {
        if (empty($_GET['id'])) {
            throw new Exception("No form ID provided.");
        }
        $assignmentId = (int) $_GET['id'];

        // fetch from DB
        $db                   = (new Database())->getConnection();
        $model                = new FormAssignment($db);
        $assignment           = $model->getById($assignmentId);

        if (!$assignment) {
            throw new Exception("Form assignment not found.");
        }
        // security check: only the assignee (or an HR user) can view
        $isHr = in_array(64, (array) $this->user['UF_DEPARTMENT']);
        if (!$isHr && $assignment['assigned_to'] != $this->user['ID']) {
            throw new Exception("You don’t have permission to view this form.");
        }

        // translate user IDs to names
        $assignment['assigned_to_name'] = $this->userMapping[$assignment['assigned_to']] ?? 'Unknown';
        $assignment['assigned_by_name'] = $this->userMapping[$assignment['assigned_by']] ?? 'Unknown';

        return [
            'title'       => 'View Form: ' . $assignment['template_name'],
            'assignment'  => $assignment,
        ];
    }
}
