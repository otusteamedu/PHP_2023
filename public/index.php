<?php

declare(strict_types=1);

use User\Php2023\App;
use User\Php2023\DependencyInjectionBootstrap;
use User\Php2023\DIContainer;

require 'vendor/autoload.php';

$container = new DIContainer();
DependencyInjectionBootstrap::setUp($container);

try {
    $app = $container->get(App::class);
    $app->run();
} catch (Exception $e) {
    throw new RuntimeException($e->getMessage());
}
