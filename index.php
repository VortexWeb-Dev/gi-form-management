<?php
$page = $_GET['page'] ?? 'dashboard';

require_once __DIR__ . '/controllers/PageController.php';

$controller = new PageController();
$controller->render($page);
