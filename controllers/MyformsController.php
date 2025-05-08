<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/FormAssignment.php';
require_once __DIR__ . '/../models/FormTemplate.php';

class MyformsController
{
    private $user;
    private $userMapping;

    public function __construct($user, $userMapping)
    {
        $this->user        = $user;
        $this->userMapping = $userMapping;
    }

    public function index(): array
    {
        // 1) DB Connection
        $database = new Database();
        $db       = $database->getConnection();

        // 2) Load models
        $assignmentModel = new FormAssignment($db);
        $templateModel   = new FormTemplate($db);

        // 3) Fetch assignments for this user
        $assignments = $assignmentModel->getByUserId($this->user['ID']);

        // 4) Map assigned_to / assigned_by IDs → names
        foreach ($assignments as &$a) {
            $a['assigned_to'] = $this->userMapping[$a['assigned_to']] ?? 'Unknown User';
            $a['assigned_by'] = $this->userMapping[$a['assigned_by']] ?? 'Unknown User';
        }
        unset($a);

        // 5) Filter to only pending and reindex
        $assignments = array_values(array_filter(
            $assignments,
            fn($a) => strtolower($a['status']) === 'pending'
        ));

        // 6) Preload all fields, grouped by template_id
        $allFields = $templateModel->getAllWithFields();
        $fieldsByTemplate = [];
        foreach ($allFields as $f) {
            // record has f['template_id'] = ft.id
            $tplId = $f['template_id'] ?? $f['id']; 
            // if your join alias differs, adjust above accordingly
            $fieldsByTemplate[$tplId][] = [
                'id'          => (int)$f['field_id'],
                'label'       => $f['label'],
                'type'        => $f['type'],
                'is_required' => (bool)$f['is_required'],
                'field_order' => (int)$f['field_order'],
                'placeholder' => $f['placeholder'],
            ];
        }

        // 7) Attach fields to each assignment
        foreach ($assignments as &$a) {
            $tplId = $a['template_id'];
            $a['fields'] = $fieldsByTemplate[$tplId] ?? [];
        }
        unset($a);

        return [
            'title'       => 'My Forms',
            'description' => 'View and manage your pending forms.',
            'assignments' => $assignments,
        ];
    }
}
