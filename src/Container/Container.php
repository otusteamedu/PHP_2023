<?php

declare(strict_types=1);

namespace App\Container;

use App\Database\Database;
use App\Database\DatabaseInterface;
use App\Http\Request;
use App\Http\RequestInterface;
use App\Router\Router;
use App\Router\RouterInterface;

readonly class Container
{
    public RequestInterface $request;
    public RouterInterface $router;
    public DatabaseInterface $database;

    public function __construct()
    {
        $this->registerServices();
    }

    private function registerServices(): void
    {
        $this->request = Request::createFromGlobals();
        $this->database = new Database();
        $this->router = new Router($this->request, $this->database);
    }
}
