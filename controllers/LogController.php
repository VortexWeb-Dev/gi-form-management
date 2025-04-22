<?php

class LogController
{
    public function index(): array
    {
        return [
            'title' => 'Audit Log',
            'description' => 'View and manage the audit log.',
        ];
    }
}
