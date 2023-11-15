<?php


use Gesparo\HW\Controller\IndexController;
use Gesparo\HW\Controller\QueueController;
use Gesparo\HW\Controller\SMSController;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add('send-message', new Route('/send', ['controller' => SMSController::class], [], [], '', [], ['POST']));
$routes->add('see-queue', new Route('/queue', ['controller' => QueueController::class], [], [], '', [], ['GET']));
$routes->add('/', new Route('/', ['controller' => IndexController::class], [], [], '', [], ['GET']));

return $routes;
