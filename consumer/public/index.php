<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\RabbitMQConsumer;

$consumer = new RabbitMQConsumer();
$consumer->run();
