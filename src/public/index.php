<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Otus\App\App;
use Otus\App\EventSourcing\Infrastructure\ConditionHydrator;
use Otus\App\EventSourcing\Infrastructure\Gateway\RedisEvenGateway;
use Otus\App\EventSourcing\Infrastructure\Repository\EventRepository;
use Predis\Client;

$app = new App(
    new RedisEvenGateway(
        new EventRepository(new Client()),
        new ConditionHydrator(),
    ),
);

$app->run();
