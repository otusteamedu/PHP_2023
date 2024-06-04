<?php

declare(strict_types=1);

namespace Propan13\App;

use Propan13\App\Router\Route;
use Propan13\App\Router\Router;
use Dotenv\Dotenv;

class Application
{
    public function run(): void
    {
        Dotenv::createUnsafeImmutable(__DIR__ . '/../config/')->load();
        $command = new Route($_SERVER['argv'][1]);
        $router = new Router();
        $router->dispatch($command);
    }
}
