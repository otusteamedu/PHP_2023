<?php

declare(strict_types=1);

namespace Propan13\App\Router;

use Exception;

class Router
{
    private array $routes = [];

    public function __construct()
    {
        $this->routes = $this->getRoutes();
    }

    /**
     ** @throws Exception
     **/
    public function dispatch(Route $route): void
    {
        if ($this->issetRoute($route)) {
            $call = new $this->routes[$route->getCommandName()];
            $call();
        } else {
            throw new Exception('Command not found');
        }
    }

    public function getRoutes(): array
    {
        $routes = include_once $_ENV['ROUTES_PATH'];
        if (is_array($routes)) {
            return $routes;
        }
        return [];
    }

    private function issetRoute(Route $route): bool
    {
        return isset($this->routes[$route->getCommandName()]);
    }
}
