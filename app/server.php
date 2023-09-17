<?php

declare(strict_types=1);

require_once('vendor/autoload.php');

use DEsaulenko\Hw19\App;
use DEsaulenko\Hw19\Queue\QueueClient;
use DEsaulenko\Hw19\Queue\QueueConsumer;
use DEsaulenko\Hw19\Queue\QueueConsumerService;
use Dotenv\Dotenv;

try {
    Dotenv::createUnsafeImmutable(__DIR__)->load();

    $client = QueueClient::getInstance()->getClient();
    $consumer = (new QueueConsumer($client))->getConsumer();
    $service = (new QueueConsumerService($consumer))->getConsumerService();

    $app = new App\ServerApp($service);
    $app->run();
} catch (Exception $e) {
    dump($e);
}
