<?php

use App\Infrastructure\Queues\Consumer\RabbitMQConsumer;

require_once __DIR__ . '/../../../../vendor/autoload.php';

try {
    $consumer = new RabbitMQConsumer();
    $consumer->run();
} catch (Exception $e) {
    print_r($e->getMessage());
}
