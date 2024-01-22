<?php

declare(strict_types=1);

namespace App\Router;

class Route
{
    public function __construct(
        private readonly string $uri,
        private readonly string $method,
        private                 $action
    )
    {
    }

    public static function get(string $uri, $action): static
    {
        return new static($uri, 'GET', $action);
    }

    public static function post(string $uri, $action): static
    {
        return new static($uri, 'POST', $action);
    }

    public static function delete(string $uri, $action): static
    {
        return new static($uri, 'DELETE', $action);
    }

    public static function put(string $uri, $action): static
    {
        return new static($uri, 'PUT', $action);
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getMethod(): string
    {
        return $this->method;
    }
}
