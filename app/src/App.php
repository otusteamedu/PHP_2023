<?php

declare(strict_types=1);

namespace Imitronov\Hw4;

use Bramus\Router\Router;
use DI\ContainerBuilder;
use Imitronov\Hw4\Components\DockerContainer;
use Imitronov\Hw4\Http\Request;

final class App
{
    private readonly Router $router;

    public function __construct()
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->useAutowiring(true);
        $containerBuilder->addDefinitions([
            Request::class => new Request($_REQUEST),
            DockerContainer::class => new DockerContainer($_SERVER['HOSTNAME']),
        ]);
        $container = $containerBuilder->build();

        /**
         * @var array{get:array<string,string[]>,post:array<string,string[]>} $routes
         */
        require dirname(__DIR__) . '/config/routes.php';
        $this->router = new Router();

        if (array_key_exists('get', $routes)) {
            foreach ($routes['get'] as $path => $controller) {
                $this->router->get($path, static fn() => $container->call($controller));
            }
        }

        if (array_key_exists('post', $routes)) {
            foreach ($routes['post'] as $path => $controller) {
                $this->router->post($path, static fn() => $container->call($controller));
            }
        }
    }

    public function run(): void
    {
        $this->router->run();
    }
}
