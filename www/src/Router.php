<?php

namespace Nalofree\Hw5;

use Exception;

class Router
{
    private array $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function addRoute($method, $path, $handlerClass, $handlerMethod): void
    {
        $route = [
            'method' => $method,
            'path' => $path,
            'handlerClass' => $handlerClass,
            'handlerMethod' => $handlerMethod
        ];
        $this->routes[] = $route;
    }

    /**
     * @throws Exception
     */
    public function handleRequest(): void
    {
        $path = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $path) {
                $handlerClass = $route['handlerClass'];
                $handlerMethod = $route['handlerMethod'];
                $handler = new $handlerClass();

                $request = new Request($_GET, $_POST, $_SERVER); // другие методы не нужны
                $response = new Response();

                $handler->$handlerMethod($request, $response);
                $response->send();
                return;
            }
        }
        header('HTTP/1.1 404 not found', true, 404);
        exit();
    }
}
