<?php

declare(strict_types=1);

use HW11\Elastic\ConsoleParameters;
use HW11\Elastic\LogicHandler;

require_once __DIR__ . '/vendor/autoload.php';

$options       = getopt('s:c:p:q:');
$consoleParams = new ConsoleParameters($options);

$logicHandler = new LogicHandler();
$logicHandler->handleLogic(
    $consoleParams->getSearchTerm(),
    $consoleParams->getCategory(),
    $consoleParams->getPrice(),
    $consoleParams->getStockQuantity()
);
