<?php

declare(strict_types=1);

namespace App\Router;

interface RouterInterface
{
    public function dispatch(string $uri, string $method): void;
}
