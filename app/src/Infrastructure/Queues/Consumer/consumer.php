<?php

declare(strict_types=1);

use App\Infrastructure\Queues\Consumer\RabbitMQConsumer;
use App\Infrastructure\Repository\RepositoryApplicationFormDb;

use App\Infrastructure\Repository\RepositoryStatusDb;

require_once __DIR__ . '/../../../../vendor/autoload.php';

try {
    $repositoryApplication = new RepositoryApplicationFormDb(new ApplicationFormMapper());
    $repositoryStatus = new RepositoryStatusDb(new StatusMapper());

    $consumer = new RabbitMQConsumer($repositoryApplication, $repositoryStatus);
    $consumer->run();
} catch (Exception $e) {
    print_r($e->getMessage());
}
