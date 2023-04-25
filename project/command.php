<?php

declare(strict_types=1);

use Vp\App\Application\Contract\AppInterface;

include "bootstrap.php";
$diConfig = require_once 'di-config.php';

try {
    $containerBuilder = new DI\ContainerBuilder();
    $containerBuilder->addDefinitions($diConfig);
    $container = $containerBuilder->build();

    $app = $container->get(AppInterface::class);
    $app->run($container, $_SERVER['argv']);
} catch (Exception $e) {
    fwrite(STDOUT, "Error: " . $e->getMessage() . PHP_EOL);
}
