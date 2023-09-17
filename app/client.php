<?php

declare(strict_types=1);

require_once('vendor/autoload.php');

use DEsaulenko\Hw19\App;
use DEsaulenko\Hw19\Queue\QueueClient;
use DEsaulenko\Hw19\Queue\QueuePublisher;
use DEsaulenko\Hw19\Queue\QueuePublisherService;
use Dotenv\Dotenv;

try {
    Dotenv::createUnsafeImmutable(__DIR__)->load();

    $client = QueueClient::getInstance()->setExchange('server')->getClient();
    $publisher = (new QueuePublisher($client))->getPublisher();
    $service = (new QueuePublisherService($publisher))->getPublisherService();

    $app = new App\PublisherApp($service);
    $app->run();
} catch (Exception $e) {
    dump($e);
}
