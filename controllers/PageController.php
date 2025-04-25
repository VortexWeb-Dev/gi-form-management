<?php

class PageController
{
    private $user;
    private $userMapping;
    // private $hrDepartmentId = 64;
    private $hrDepartmentId = 444;

    public function __construct($user, $userMapping)
    {
        $this->user = $user;
        $this->userMapping = $userMapping;
    }

    public function render($page)
    {
        $userId = $this->user['ID'];
        $isHR = in_array($this->hrDepartmentId, (array) $this->user['UF_DEPARTMENT']);

        if ($isHR) {
            $allowed = ['dashboard', 'inbox', 'archive', 'templates', 'config', 'track', 'send', 'log', 'notifications', 'addtemplate'];
        } else {
            $allowed = ['myforms', 'fill', 'submitted', 'history', 'alerts'];
        }

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
                $controller = new $controllerClass($this->user, $this->userMapping);

                if (method_exists($controller, 'index')) {
                    $data = $controller->index();
                }
            }
        }

        $data['isHR'] = $isHR;
        $data['userId'] = $userId;
        $data['user'] = $this->user;

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
