<?php

require 'vendor/autoload.php';

use Nalofree\Hw5\Router;

$router = new Router();

$router->addRoute('POST', '/check', 'Nalofree\Hw5\IndexController', 'check');
$router->addRoute('GET', '/', 'Nalofree\Hw5\IndexController', 'index');

$router->handleRequest();
