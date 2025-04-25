<?php
$page = $_GET['page'] ?? 'dashboard';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/controllers/PageController.php';
require_once __DIR__ . '/crest/crestcurrent.php';

$result = CRestCurrent::call('user.current');
if (isset($result['error'])) {
    echo '<h1>Error</h1>';
    echo '<p>' . htmlspecialchars($result['error']) . '</p>';
    exit;
}
$user = $result['result'];

$controller = new PageController($user, require_once __DIR__ . ('/data/userMapping.php'));
$controller->render($page);
