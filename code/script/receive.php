<?php

declare(strict_types=1);

require '../vendor/autoload.php';

(new \Art\Code\Application\Helper\DotEnv(__DIR__ . '/../.env'))->load();

$cn = new \Art\Code\Infrastructure\Broker\Rabbit\RabbitMQConnector();
$requestService = new \Art\Code\Infrastructure\Services\Request\RequestService();
$emailPublisher = new \Art\Code\Infrastructure\Services\Queue\EmailPublisher\EmailPublisher($cn);

$pdo = (new \Art\Code\Infrastructure\DB\PDO\PDOConnection())->getConnection();
$requestTypeRepository = new \Art\Code\Infrastructure\Repository\RequestTypeRepository($pdo);
$requestStatusRepository = new \Art\Code\Infrastructure\Repository\RequestStatusRepository($pdo);
$userRepository = new \Art\Code\Infrastructure\Repository\UserRepository($pdo);
$requestRepository = new \Art\Code\Infrastructure\Repository\RequestRepository($pdo, $userRepository, $requestStatusRepository, $requestTypeRepository);

$consumer = new \Art\Code\Infrastructure\Services\Queue\RequestConsumer\RequestConsumer($cn, $requestService, $emailPublisher, $requestRepository);
$consumer->get();