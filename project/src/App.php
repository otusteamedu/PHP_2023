<?php

declare(strict_types=1);

namespace Vp\App;

use Silex\Application;
use Symfony\Component\Validator\Validation;
use Vp\App\Services\Preparer;
use Vp\App\Services\Verifier;
use Vp\App\Validators\Constraints\PeriodFormConstraints;
use Vp\App\Validators\Constraints\EmailsFormConstraints;
use Vp\App\Validators\Constraints\FileFormConstraints;
use Vp\App\Validators\Validator;

class App
{
    private array $routes;
    private Application $app;

    public function __construct($routes, $silexApp)
    {
        $this->routes = $routes;
        $this->app = $silexApp;

        $this->initSilex();

        $this->registerConstraints();
        $this->registerServices();
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

    private function registerServices(): void
    {
        $this->app['services.verifier'] = function () {
            return new Verifier();
        };

        $this->app['services.validator'] = function () {
            return new Validator(Validation::createValidator());
        };

        $this->app['services.preparer'] = function () {
            return new Preparer();
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
