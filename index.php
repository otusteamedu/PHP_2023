<?php

declare(strict_types=1);

use HW11\Elastic\ConsoleParameters;
use HW11\Elastic\LogicHandler;

require_once __DIR__ . '/vendor/autoload.php';

$consoleParams = new ConsoleParameters(getopt('s:c:p:q:'));

$searchTerm    = $consoleParams->getSearchTerm();
$category      = $consoleParams->getCategory();
$price         = $consoleParams->getPrice();
$stockQuantity = $consoleParams->getStockQuantity();

$logicHandler = new LogicHandler();
$logicHandler->handleLogic($searchTerm, $category, $price, $stockQuantity);
