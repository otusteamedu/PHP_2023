<?php

use App\Infrastructure\Queues\Consumer\RabbitMQConsumer;
use App\Infrastructure\Repository\DbRepository;
use App\Infrastructure\Notification\EmailEmailNotification;

require_once __DIR__ . '/../../../../vendor/autoload.php';

try {
    $consumer = new RabbitMQConsumer(new DbRepository(), new EmailEmailNotification());
    $consumer->run();
} catch (Exception $e) {
    print_r($e->getMessage());
}
