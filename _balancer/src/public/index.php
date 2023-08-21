<?php

declare(strict_types=1);

namespace Ndybnov\Hw04\public;

require __DIR__ . '/../vendor/autoload.php';


use Ndybnov\Hw04\hw\commands\RoutersHandlerCommand;
use Slim\Factory\AppFactory;

try {
    $app = AppFactory::create();

    $app->post(
        '/',
        RoutersHandlerCommand::build()->make('post-root')
    );

    $app->get(
        '/check-cache/',
        RoutersHandlerCommand::build()->make('get-check-cache')
    );

    $app->get(
        '/',
        RoutersHandlerCommand::build()->make('get-root')
    );

    $app->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}
