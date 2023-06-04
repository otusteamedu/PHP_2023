<?php

declare(strict_types=1);

namespace Vp\App\Application;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;
use Vp\App\Application\Builder\AmqpConnectionBuilder;
use Vp\App\Application\Builder\PostgresConnectionBuilder;
use Vp\App\Application\Constraint\OrderConstraints;
use Vp\App\Application\Dto\Api\Config;
use Vp\App\Application\RabbitMq\RabbitSender;
use Vp\App\Application\UseCase\Order;
use Vp\App\Application\UseCase\Queue;
use Vp\App\Application\Validator\Validator;
use Vp\App\Infrastructure\Exception\ApiConfigNotFound;
use Vp\App\Infrastructure\Middleware\Auth;
use Vp\App\Infrastructure\Middleware\Json;

class App
{
    private Application $app;

    /**
     * @throws ApiConfigNotFound
     */
    public function __construct($routes, $config, $silexApp, $env)
    {
        $this->app = $silexApp;

        $this->initSilex();
        $this->registerConfig($config);
        $this->registerConstraints();
        $this->registerServices($env);
        $this->registerModels($env);
        $this->registerMiddlewares();
        $this->registerRoutes($routes);
    }

    private function initSilex(): void
    {
        $this->app['debug'] = true;
    }

    /**
     * @throws ApiConfigNotFound
     */
    private function registerConfig(array $config): void
    {
        if (!isset($config['apiKeyName']) || !isset($config['token'])) {
            throw new ApiConfigNotFound('Api config not found');
        }

        $this->app['config'] = function () use ($config) {
            return new Config(
                $config['apiKeyName'] ?? null,
                    $config['token'] ?? null
            );
        };
    }

    private function registerConstraints(): void
    {
        $this->app['constraint.order'] = function () {
            return new OrderConstraints();
        };
    }

    private function registerServices(array $env): void
    {
        $this->app['services.validator'] = function () {
            return new Validator(Validation::createValidator());
        };

        $this->app['useCase.order'] = function () {
            return new Order($this->app);
        };

        $amqpConnectionBuilder = new AmqpConnectionBuilder();
        $amqpConnectionBuilder
            ->setHost($env['RBMQ_HOST'])
            ->setPort($env['RBMQ_PORT'])
            ->setUser($env['RBMQ_USER'])
            ->setPassword($env['RBMQ_PASSWORD'])
        ;

        $this->app['useCase.queue'] = function () use ($amqpConnectionBuilder) {
            return new Queue(new RabbitSender($amqpConnectionBuilder->build()));
        };
    }

    private function registerModels(array $env): void
    {
        $pgConnectionBuilder = new PostgresConnectionBuilder();
        $pgConnectionBuilder
            ->setUser($env['DB_USERNAME'])
            ->setPassword($env['DB_PASSWORD'])
            ->setPort($env['DB_PORT'])
            ->setHost($env['DB_HOST'])
            ->setName($env['DB_NAME']);

        $this->app['models.order'] = function () use ($pgConnectionBuilder) {
            return new \Vp\App\Domain\Model\Order($pgConnectionBuilder->build());
        };
        $this->app['models.status'] = function () use ($pgConnectionBuilder) {
            return new \Vp\App\Domain\Model\Status($pgConnectionBuilder->build());
        };
    }

    private function registerMiddlewares(): void
    {
        $this->app['middleware.json'] = function () {
            return new Json();
        };

        $this->app['middleware.auth'] = function () {
            return new Auth();
        };
    }

    private function registerRoutes(array $routes): void
    {
        foreach ($routes as $route => $routeParams) {
            $method = strtolower($routeParams['method']);
            $objRoute = $this->app->{$method}($route, $routeParams['controller'] . '::' . $routeParams['action']);

            foreach ($routeParams['middleWare'] as $middleWare) {
                $objRoute->before(function (Request $request) use ($middleWare) {
                    return $this->app['middleware.' . $middleWare]->handle($request, $this->app);
                });
            }
        }
    }

    public function run(): void
    {
        $this->app->run();
    }
}
