<?php

use Illuminate\Container\Container;
use Illuminate\Queue\Capsule\Manager as Queue;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$container = new Container;
$queue = new Queue($container);

$queue->addConnection([
    'driver' => 'redis',
    'host' => getenv('QUEUE_HOST'),
    'port' => getenv('QUEUE_PORT'),
    'database' => getenv('QUEUE_DATABASE'),
    'password' => getenv('QUEUE_PASSWORD'),
    'queue' => getenv('QUEUE_NAME'),
]);

$queue->setAsGlobal();
