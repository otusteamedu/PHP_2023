<?php

declare(strict_types=1);

use App\App;
use App\Application\Dto\ConditionsDto;
use App\Infrastructure\Factory\ClientFactory;
use App\Infrastructure\Factory\IndexFactory;
use App\Infrastructure\Repository\EventRepository;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $app = new App(new EventRepository(IndexFactory::create(ClientFactory::create())));
} catch (Exception $e) {
    echo 'App creation failed. Error: ' . $e->getMessage();
    exit();
}

try {
    $app->add();
} catch (Exception $e) {
    echo 'Events adding failed. Error: ' . $e->getMessage();
}

$conditionsDto = new ConditionsDto(['param1' => 1, 'param2' => 2]);

try {
    $event = $app->get($conditionsDto);
} catch (Exception $e) {
    echo 'Events getting failed. Error: ' . $e->getMessage();
}
