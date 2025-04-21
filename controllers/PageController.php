<?php

class PageController
{
    public function render($page)
    {
        $allowed = ['dashboard', 'inbox', 'archive', 'templates', 'config'];

        if (!in_array($page, $allowed)) {
            $page = 'dashboard';
        }

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

        extract($data);

        include __DIR__ . '/../views/layout/head.php';

        echo '<div class="flex h-screen">';
        include __DIR__ . '/../views/layout/sidebar.php';

        echo '<main class="flex-1 overflow-y-auto p-6">';
        include __DIR__ . '/../views/' . $page . '.php';
        echo '</main></div>';

        include __DIR__ . '/../views/layout/footer.php';
    }
}
