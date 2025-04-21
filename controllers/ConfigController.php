<?php

class ConfigController
{
    public function index(): array
    {
        return [
            'title' => 'Config',
            'description' => 'Manage application settings and configurations.',
        ];
    }
}
