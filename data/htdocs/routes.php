<?php

use Sva\Event\Infrastructure\Http\Controller as EventController;
use Sva\Common\Infrastructure\Http\Controller as CommonController;

$app = \Sva\Common\App\App::getInstance();
$app->getRouter()->get('/', CommonController::class . '@get');
$app->getRouter()->get('/events', EventController::class . '@get');
$app->getRouter()->post('/events', EventController::class . '@post');
$app->getRouter()->post('/events/clear', EventController::class . '@clear');
