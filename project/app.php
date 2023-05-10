<?php

declare(strict_types=1);

error_reporting(E_ERROR);

use Vp\App\Application\Contract\AppInterface;

require_once('vendor/autoload.php');
require_once('bootstrap.php');
$diConfig = require_once 'di-config.php';

try {
    $containerBuilder = new DI\ContainerBuilder();
    $containerBuilder->addDefinitions($diConfig);
    $container = $containerBuilder->build();

    $app = $container->get(AppInterface::class);
    $app->run($container, $_SERVER['argv']);
} catch (Exception $e) {
    fwrite(STDERR, "Error: " . $e->getMessage() . PHP_EOL);
}
