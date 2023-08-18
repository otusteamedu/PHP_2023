<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Root\App\Application\Worker;

require __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);

$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);

$container = $containerBuilder->build();

$worker = new Worker('worker', $container);
$worker->run();
