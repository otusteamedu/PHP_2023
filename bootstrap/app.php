<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpCache\Esi;
use Symfony\Component\HttpKernel\HttpCache\HttpCache;
use Symfony\Component\HttpKernel\HttpCache\Store;

require __DIR__ . '/../vendor/autoload.php';

// Load Variables
$dotenv = new Dotenv();
$dotenv->load(
    __DIR__ . '/../.env.master',
    __DIR__ . '/../.env.replica'
);

$routes = include_once __DIR__ . '/../routes/api.php';
$container = include_once __DIR__ . '/../config/container.php';

$container->setParameter('debug', true);
$container->setParameter('charset', 'UTF-8');
$container->setParameter('cache_dir', __DIR__ . '/../cache');

$request = Request::createFromGlobals();

$app = $container->get('cached_app');

$response = $app->handle($request);

$response->send();
