<?php

class DashboardController
{
    public function index(): array
    {
        return [
            'title' => 'Dashboard',
            'description' => 'Summary of forms, pending actions and insights.'
        ];
    }
}
