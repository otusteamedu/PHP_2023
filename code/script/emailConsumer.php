<?php

declare(strict_types=1);

require '../vendor/autoload.php';

(new \Art\Code\Application\Helper\DotEnv(__DIR__ . '/../.env'))->load();

$cn = new \Art\Code\Infrastructure\Broker\Rabbit\RabbitMQConnector();
$consumer = new \Art\Code\Infrastructure\Services\Queue\EmailConsumer\EmailConsumer($cn);
$consumer->get();