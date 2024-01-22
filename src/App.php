<?php

declare(strict_types=1);

namespace App;

use App\Container\Container;

class App
{
    private Container $container;

    public function __construct()
    {
        $this->container = new Container();
    }

    public function run(): void
    {
        header('Content-type: application/json');

        $this->container->router->dispatch(
            $this->container->request->uri(),
            $this->container->request->method());
    }
}
