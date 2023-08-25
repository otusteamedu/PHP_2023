<?php

use IilyukDmitryi\App;
use IilyukDmitryi\App\Application\UseCase\CreateBurgerUseCase;
use IilyukDmitryi\App\Domain\Order\OrderStrategyInterface;

require_once('vendor/autoload.php');

try {
   /* $diConfig = require_once 'di-config.php';

    $containerBuilder = new DI\ContainerBuilder();
    $containerBuilder->addDefinitions($diConfig);
    $container = $containerBuilder->build();
    $tt = $container->get(OrderStrategyInterface::class);
    $tt = $container->get(CreateBurgerUseCase::class);
    var_dump($tt);
    echo '<pre>' . print_r([($container)->has(OrderStrategyInterface::class)],
            1) . '</pre>' . __FILE__ . ' # ' . __LINE__;//test_delete
    die;//test_delete*/
    $container = App\Di::getContainer();
    $app = $container->get(App\App::class);
    $app->run();
} catch (Exception $e) {
    echo 'Exception ' . $e->getMessage();
}
