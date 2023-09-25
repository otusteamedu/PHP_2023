<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure;

use Art\Code\Infrastructure\Response\Response;

class RouteManager
{
    const ALLOWED_ACTIONS = ['index', 'get', 'delete', 'post'];
    const ALLOWED_ROUTES = ['request', 'documentation'];
    const NAMESPACE = "Art\\Code\\Infrastructure\\Controller\\Api\\v1\\";

    public function __construct()
    {
        $url = strtok($_SERVER["REQUEST_URI"], '?');
        $routes = explode('/', $url);
        $controller_name = '';
        $action_name = '';

        if (empty($routes[3]) || !in_array(strtolower($routes[3]), self::ALLOWED_ROUTES)) {

            $this->noPage();
        } else {
            $route = ucfirst(strtolower($routes[3]));
            $controller_name = self::NAMESPACE . "{$route}Controller";
        }

        if (empty($routes[4])) {
            $action_name = "index";
        } else if (!in_array(strtolower($routes[4]), self::ALLOWED_ACTIONS)) {
            $this->noPage();
        } else {
            $action_name = strtolower($routes[4]);
        }

        if (!class_exists($controller_name, true)) {
            $this->noPage();
        }
        if (!method_exists($controller_name, $action_name)) {
            $this->noPage();
        }

        $controller = new $controller_name();
        $controller->$action_name();
    }

    private function noPage(): void
    {
        Response::send(Response::HTTP_CODE_BAD_REQUEST, "No such page!");
    }
}