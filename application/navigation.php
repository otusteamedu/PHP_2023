<?php

use Gesparo\HW\Infrastructure\Controller\AddController;
use Gesparo\HW\Infrastructure\Controller\ClearController;
use Gesparo\HW\Infrastructure\Controller\GetController;
use Gesparo\HW\Infrastructure\Controller\IndexController;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add('add', new Route('/add', ['controller' => AddController::class], [], [], '', [], ['POST']));
$routes->add('clear', new Route('/clear', ['controller' => ClearController::class], [], [], '', [], ['POST']));
$routes->add('get', new Route('/get', ['controller' => GetController::class], [], [], '', [], ['POST']));
$routes->add('/', new Route('/', ['controller' => IndexController::class], [], [], '', [], ['GET']));

return $routes;
