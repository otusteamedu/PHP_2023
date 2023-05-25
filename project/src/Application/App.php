<?php

declare(strict_types=1);

namespace Vp\App\Application;

use Silex\Application;
use Symfony\Component\Validator\Validation;
use Vp\App\Application\Builder\AmqpConnectionBuilder;
use Vp\App\Application\Constraint\PeriodFormConstraints;
use Vp\App\Application\RabbitMq\RabbitSender;
use Vp\App\Application\UseCase\BankStatementPeriod;
use Vp\App\Application\Validator\Validator;
use Vp\App\Services\Verifier;

class App
{
    private array $routes;
    private Application $app;

    public function __construct($routes, $silexApp, $env)
    {
        $this->routes = $routes;
        $this->app = $silexApp;

        $this->initSilex();

        $this->registerConstraints();
        $this->registerServices($env);
        $this->registerRoutes();
    }

    private function initSilex(): void
    {
        $this->app['debug'] = true;
    }

    private function registerConstraints(): void
    {
        $this->app['constraint.period'] = function () {
            return new PeriodFormConstraints();
        };
    }

    private function registerServices(array $env): void
    {
        $this->app['services.verifier'] = function () {
            return new Verifier();
        };

        $this->app['services.validator'] = function () {
            return new Validator(Validation::createValidator());
        };

        $amqpConnectionBuilder = new AmqpConnectionBuilder();
        $amqpConnectionBuilder
            ->setHost($env['RBMQ_HOST'])
            ->setPort($env['RBMQ_PORT'])
            ->setUser($env['RBMQ_USER'])
            ->setPassword($env['RBMQ_PASSWORD'])
        ;

        $this->app['bank.statement.period'] = function () use ($amqpConnectionBuilder) {
            return new BankStatementPeriod(new RabbitSender($amqpConnectionBuilder->build()));
        };
    }

    private function registerRoutes(): void
    {
        foreach ($this->routes as $route => $routeParams) {
            $method = strtolower($routeParams['method']);
            $this->app->{$method}($route, $routeParams['controller'] . '::' . $routeParams['action']);
        }
    }

    public function run(): void
    {
        $this->app->run();
    }
}
