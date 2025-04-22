<?php
$page = $_GET['page'] ?? 'dashboard';

require_once __DIR__ . '/controllers/PageController.php';
require_once __DIR__ . '/crest/crestcurrent.php';

$result = CRestCurrent::call('user.current');
if (isset($result['error'])) {
    echo '<h1>Error</h1>';
    echo '<p>' . htmlspecialchars($result['error']) . '</p>';
    exit;
}
$user = $result['result'];

$controller = new PageController($user);
$controller->render($page);
