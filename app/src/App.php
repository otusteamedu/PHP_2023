<?php

declare(strict_types=1);

namespace Imitronov\Hw12;

use Bramus\Router\Router;
use DI\Container;
use DI\ContainerBuilder;
use Imitronov\Hw12\Application\Repository\EventRepository;
use Imitronov\Hw12\Application\UseCase\Event\CreateEventsInput;
use Imitronov\Hw12\Application\UseCase\Event\SearchEventsInput;
use Imitronov\Hw12\Infrastructure\Component\RedisClient;
use Imitronov\Hw12\Infrastructure\Exception\ExceptionHandler;
use Imitronov\Hw12\Infrastructure\Http\Event\RequestCreateEventsInput;
use Imitronov\Hw12\Infrastructure\Http\Event\RequestSearchEventsInput;
use Imitronov\Hw12\Infrastructure\Http\JsonResponse;
use Imitronov\Hw12\Infrastructure\Http\Response;
use Imitronov\Hw12\Infrastructure\Repository\RedisEventRepository;
use Symfony\Component\Dotenv\Dotenv;

final class App
{
    private readonly Router $router;

    public function __construct()
    {
        (new Dotenv())->load(dirname(__DIR__) . '/.env');
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->useAutowiring(true);
        $containerBuilder->addDefinitions([
            RedisClient::class => static fn () => new RedisClient(
                new \Redis(),
                $_ENV['REDIS_HOST'],
                (int) $_ENV['REDIS_PORT'],
            ),
            EventRepository::class => static fn (Container $container) => $container->get(RedisEventRepository::class),
            CreateEventsInput::class => static fn (Container $container) => $container->get(RequestCreateEventsInput::class),
            SearchEventsInput::class => static fn (Container $container) => $container->get(RequestSearchEventsInput::class),
        ]);
        $container = $containerBuilder->build();

        /**
         * @var array{get:array<string,string[]>,post:array<string,string[]>} $routes
         */
        require dirname(__DIR__) . '/config/routes.php';
        $this->router = new Router();
        $controllerHandler = function ($controller) use ($container) {
            try {
                $response = $container->call($controller);
            } catch (\Throwable $exception) {
                $exceptionHandler = $container->get(ExceptionHandler::class);
                $response = $exceptionHandler->handle($exception);
            }

            if ($response instanceof Response) {
                $response->output();
            }
        };

        if (array_key_exists('get', $routes)) {
            foreach ($routes['get'] as $path => $controller) {
                $this->router->get($path, static fn() => $controllerHandler($controller));
            }
        }

        if (array_key_exists('post', $routes)) {
            foreach ($routes['post'] as $path => $controller) {
                $this->router->post($path, static fn() => $controllerHandler($controller));
            }
        }

        if (array_key_exists('delete', $routes)) {
            foreach ($routes['delete'] as $path => $controller) {
                $this->router->delete($path, static fn() => $controllerHandler($controller));
            }
        }

        $this->router->set404(function () {
            (new JsonResponse(['error' => 'Page not found.'], 404))->output();
        });
    }

    public function run(): void
    {
        $this->router->run();
    }
}
