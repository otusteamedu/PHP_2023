<?php

namespace Ndybnov\Hw04\hw;

use Ndybnov\Hw04\hw\commands\RoutersHandlerCommand;
use Slim\Factory\AppFactory;
use Slim\App;

class AppWrapper
{
    private App $app;
    private function __construct()
    {
        $this->app = AppFactory::create();
    }

    public static function build(): self
    {
        return new self();
    }

    public function run(): void
    {
        $this->app->post(
            '/',
            RoutersHandlerCommand::build()->make('post-root')
        );

        $this->app->get(
            '/check-cache/',
            RoutersHandlerCommand::build()->make('get-check-cache')
        );

        $this->app->get(
            '/',
            RoutersHandlerCommand::build()->make('get-root')
        );

        $this->app->run();
    }
}
