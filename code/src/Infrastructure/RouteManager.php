<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure;

use Art\Code\Infrastructure\View\View;

class RouteManager
{
    const ALLOWED_ACTIONS = ['index', 'get', 'delete'];
    const ALLOWED_ROUTES = ['statement',''];
    const NAMESPACE = "Art\\Code\\Infrastructure\\Controller\\";

    public function __construct()
    {
        $url = strtok($_SERVER["REQUEST_URI"], '?');
        $routes = explode('/', $url);

        if (empty($routes[1] && in_array(strtolower($routes[1]),self::ALLOWED_ROUTES)) ) {
            $this->viewRender();
        }
        else{
            $route = ucfirst(strtolower($routes[1]));
            $controller_name = self::NAMESPACE."{$route}Controller";
        }

        if (empty($routes[2] && in_array(strtolower($routes[2]),self::ALLOWED_ACTIONS)) ) {
            $this->viewRender();
        }
        $action_name = strtolower($routes[2]);

        // redirect to 404
        if (!class_exists($controller_name, true)) {
            $this->viewRender();
        }

        // redirect to 404
        if(!method_exists($controller_name, $action_name)) {
            $this->viewRender();
        }

        $controller = new $controller_name();
        $controller->$action_name();
    }

    private function viewRender(): void
    {
        View::render('error/404', [
            'title' => 'Ошибка 404',
            'error_code' => '404 - Not Found',
            'result' => 'Нет такой страницы'
        ]);
    }
}