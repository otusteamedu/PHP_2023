<?php

declare(strict_types=1);

namespace App\Router;

use App\Controllers\Controller;
use App\Database\DatabaseInterface;
use App\Http\RequestInterface;
use JetBrains\PhpStorm\NoReturn;

class Router implements RouterInterface
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => []
    ];

    public function __construct(
        private readonly RequestInterface $request,
        private readonly DatabaseInterface $database
    ) {
        $this->initRoutes();
    }

    public function dispatch(string $uri, string $method): void
    {
        $route = $this->findRoute($uri, $method);

        if (!$route) {
            $this->notFound();
        }

        if (is_array($route->getAction())) {
            [$controller, $action] = $route->getAction();

            /** @var Controller $controller */
            $controller = new $controller($this->database);

            call_user_func([$controller, 'setRequest'], $this->request);
            call_user_func([$controller, $action]);
        } else {
            call_user_func($route->getAction());
        }
    }

    #[NoReturn] private function notFound(): void
    {
        http_response_code(404);
        echo '404 | Not Found';
        exit;
    }

    private function findRoute(string $uri, string $method): Route|false
    {
        if (!isset($this->routes[$method][$uri])) {
            return false;
        }

        return $this->routes[$method][$uri];
    }

    private function initRoutes(): void
    {
        $routes = $this->getRoutes();

        foreach ($routes as $route) {
            $this->routes[$route->getMethod()][$route->getUri()] = $route;
        }
    }

    /**
     * @return Route[]
     */
    private function getRoutes(): array
    {
        return require_once APP_PATH . '/src/Router/routes.php';
    }
}
