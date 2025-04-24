<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/FormTemplate.php';

class TemplatesController
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

        $templates = $FormTemplateModel->getAll();
        foreach ($templates as &$template) {
            $template['created_by'] = $this->userMapping[$template['created_by']] ?? 'Unknown User';
        }

        return [
            'title' => 'Templates',
            'description' => 'View and manage form templates.',
            'templates' => $templates,
        ];
    }
}
