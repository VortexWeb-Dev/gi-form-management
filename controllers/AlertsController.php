<?php

class AlertsController
{
    public function index(): array
    {
        return [
            'title' => 'Alerts',
            'description' => 'Stay updated on assigned forms and pending submissions.',
        ];
    }
}
