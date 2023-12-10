<?php

use App\Infrastructure\Queues\Consumer\RabbitMQConsumer;

require_once __DIR__ . '/../../../vendor/autoload.php';

$consumer = new RabbitMQConsumer();
$consumer->run();
