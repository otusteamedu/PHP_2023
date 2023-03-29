<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpCache\Esi;
use Symfony\Component\HttpKernel\HttpCache\HttpCache;
use Symfony\Component\HttpKernel\HttpCache\Store;
use Twent\Hw12\App;

require __DIR__ . '/../vendor/autoload.php';

// Load Variables
$dotenv = new Dotenv();
$dotenv->load(
    __DIR__ . '/../.env.master',
    __DIR__ . '/../.env.replica'
);

$routes = include_once __DIR__ . '/../routes/api.php';
$sc = include_once __DIR__ . '/../config/container.php';

$sc->setParameter('debug', true);
$sc->setParameter('charset', 'UTF-8');

$request = Request::createFromGlobals();

$app = $sc->get('app');

$app = new HttpCache($app, new Store(__DIR__ . '/../cache'), new Esi()/*['debug' => true]*/);

$response = $app->handle($request);

$response->send();
