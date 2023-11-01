<?php

use Gesparo\HW\Controller\AddController;
use Gesparo\HW\Controller\ClearController;
use Gesparo\HW\Controller\GetController;
use Gesparo\HW\Controller\IndexController;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add('add', new Route('/add', ['controller' => AddController::class], [], [], '', [], ['POST']));
$routes->add('clear', new Route('/clear', ['controller' => ClearController::class], [], [], '', [], ['POST']));
$routes->add('get', new Route('/get', ['controller' => GetController::class], [], [], '', [], ['POST']));
$routes->add('/', new Route('/', ['controller' => IndexController::class], [], [], '', [], ['GET']));

return $routes;