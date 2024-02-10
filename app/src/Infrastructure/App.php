<?php

declare(strict_types=1);

namespace Yevgen87\App\Infrastructure;

use DI\ContainerBuilder;
use Yevgen87\App\Infrastructure\Router;

class App
{
    public function run()
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions(__DIR__ . '/config/app.php');
        $container = $containerBuilder->build();

        $router = new Router($container);
        return $router->handle();
    }
}
