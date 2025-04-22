<?php

class PageController
{
    public function render($page)
    {
        // Hardcoded user ID for now (simulate login)
        $userId = 1; // Change this to test HR (1) or regular User (e.g., 2)
        $isHR = $userId === 1;

        // Allowed pages depending on the role
        if ($isHR) {
            $allowed = ['dashboard', 'inbox', 'archive', 'templates', 'config', 'track', 'send', 'log', 'notifications'];
        } else {
            $allowed = ['myforms', 'fill', 'submitted', 'history', 'notifications'];
        }

        // Fallback to default page
        if (!in_array($page, $allowed)) {
            $page = $isHR ? 'dashboard' : 'myforms';
        }

        // Load controller
        $controllerFile = __DIR__ . '/' . ucfirst($page) . 'Controller.php';
        $controllerClass = ucfirst($page) . 'Controller';
        $data = [];

        if (file_exists($controllerFile)) {
            require_once $controllerFile;

            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();

                if (method_exists($controller, 'index')) {
                    $data = $controller->index();
                }
            }
        }

        // Pass role and user ID to views
        $data['isHR'] = $isHR;
        $data['userId'] = $userId;

        extract($data);

        include __DIR__ . '/../views/layout/head.php';

        echo '<div class="flex h-screen">';
        include __DIR__ . '/../views/layout/sidebar.php'; // This should use $isHR to render links

        echo '<main class="flex-1 overflow-y-auto p-6">';
        include __DIR__ . '/../views/' . $page . '.php';
        echo '</main></div>';

        include __DIR__ . '/../views/layout/footer.php';
    }
}
