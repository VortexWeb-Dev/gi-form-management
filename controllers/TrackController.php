<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/FormAssignment.php';
require_once __DIR__ . '/../models/DigitalSignature.php';

class TrackController
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
        $digitalSignatureModel = new DigitalSignature($db);

        // $assignments = $formAssignmentModel->getByHrId($this->user['ID']);
        $assignments = $formAssignmentModel->getByHrId(1938);
        foreach ($assignments as &$assignment) {
            $assignment['assigned_to'] = $this->userMapping[$assignment['assigned_to']] ?? 'Unknown User';
            $assignment['assigned_by'] = $this->userMapping[$assignment['assigned_by']] ?? 'Unknown User';
            $assignment['signature'] = $digitalSignatureModel->getByAssignment($assignment['id']) ?? null;
            if ($assignment['signature']) {
                $assignment['signature']['signed_by'] = $this->userMapping[$assignment['signature']['signed_by']] ?? 'Unknown User';
            }
        }

        return [
            'title' => 'Track Signatures',
            'description' => 'Track the status of your forms and submissions.',
            'assignments' => $assignments,
        ];
    }
}
