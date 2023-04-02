<?php

declare(strict_types=1);

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use Twent\Hw12\DI\Container;

require __DIR__ . '/../vendor/autoload.php';

// Load Variables
$dotenv = new Dotenv();
$dotenv->load(
    __DIR__ . '/../.env.master',
    __DIR__ . '/../.env.replica'
);

$container = Container::getInstance();

$container->setParameter('debug', true);
$container->setParameter('charset', 'UTF-8');
$container->setParameter('routes', __DIR__ . '/../routes/api.php');
$container->setParameter('cache_dir', __DIR__ . '/../cache');

$loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../config'));
$loader->load('container.php');

$request = Request::createFromGlobals();

$app = $container->get('cached_app');

$response = $app->handle($request);

$response->send();
