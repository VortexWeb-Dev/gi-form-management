<?php

class ArchiveController
{
    public function index(): array
    {
        return [
            'title' => 'Archive',
            'description' => 'View and manage archived forms.'
        ];
    }
}
