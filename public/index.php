<?php

require __DIR__ . '/../vendor/autoload.php';

use Patterns\Daniel\App;
use Patterns\Daniel\Patterns\AbstractFactory\BurgerFactory;
use Patterns\Daniel\Patterns\Builder\OrderBuilder;
use Patterns\Daniel\Patterns\Observer\PreparationObserver;

$productFactory = new BurgerFactory();
$orderBuilder = new OrderBuilder();
$preparationObserver = new PreparationObserver();

$app = new App($productFactory, $orderBuilder, $preparationObserver);
$app->run();
