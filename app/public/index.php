<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Root\App\Settings;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);

$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);

$container = $containerBuilder->build();

AppFactory::setContainer($container);
$app = AppFactory::create();

$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

$settings = $container->get(Settings::class);


$errorMiddleware = $app->addErrorMiddleware(
    $settings->get('displayErrorDetails'),
    $settings->get('logError'),
    $settings->get('logErrorDetails'));

$app->run();
