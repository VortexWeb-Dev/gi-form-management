<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/FormTemplate.php';

class FillController
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
        $FormTemplateModel = new FormTemplate($db);

        $originalData = $FormTemplateModel->getAllWithFields();

        $templates = [];

        foreach ($originalData as $record) {
            $templateId = $record['id'];

            if (!isset($templates[$templateId])) {
                $templates[$templateId] = [
                    'id' => $templateId,
                    'title' => $record['title'],
                    'description' => $record['description'],
                    'file_path' => $record['file_path'],
                    'created_by' => $record['created_by'],
                    'created_at' => $record['created_at'],
                    'updated_at' => $record['updated_at'],
                    'is_active' => $record['is_active'],
                    'fields' => []
                ];
            }

            $templates[$templateId]['fields'][] = [
                'id'          => $record['field_id'],
                'label'       => $record['label'],
                'type'        => $record['type'],
                'is_required' => $record['is_required'],
                'field_order' => $record['field_order'],
                'placeholder' => $record['placeholder'],
            ];
        }

        return [
            'title' => 'Fill and Sign',
            'description' => 'Fill out and sign forms online.',
            'templates' => $templates,
        ];
    }
}
