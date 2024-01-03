<?php

namespace Common\Infrastructure;

class RouteGroup extends AbstractRoute
{
    public function __construct(string $path, string $name, private array $routes)
    {
        parent::__construct($path, $name);
    }

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}