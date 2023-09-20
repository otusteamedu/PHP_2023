<?php

declare(strict_types=1);

require '../vendor/autoload.php';

(new \Art\Code\Application\Helper\DotEnv(__DIR__ . '/../.env'))->load();

$cn = new \Art\Code\Infrastructure\Rabbit\RabbitMQConnector();
$statementService = new \Art\Code\Infrastructure\Services\Statement\StatementService();
$emailPublisher  = new \Art\Code\Infrastructure\Services\Queue\EmailPublisher\EmailPublisher($cn);
$consumer = new \Art\Code\Infrastructure\Services\Queue\StatementConsumer\StatementConsumer($cn,$statementService, $emailPublisher );
$consumer->get();