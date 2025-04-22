<?php

class DashboardController
{
    public function index(): array
    {
        return [
            'title' => 'Dashboard',
            'description' => 'Overview of recent activity, pending approvals, and quick actions.'
        ];
    }
}
