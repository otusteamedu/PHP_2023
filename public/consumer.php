<?php

declare(strict_types=1);

use User\Php2023\Application\QueueConsumeHandler;
use User\Php2023\Infrastructure\Queue\RabbitMQQueue;

require 'vendor/autoload.php';
require_once 'src/config.php';

$messageHandler = $container->get(QueueConsumeHandler::class);
$queue =  $container->get(RabbitMQQueue::class);
$queue->consumeWithHandler($messageHandler);
