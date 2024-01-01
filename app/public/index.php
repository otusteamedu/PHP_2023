<?php

declare(strict_types=1);

use App\App;
use App\Application\Dto\ConditionsDto;
use App\Application\Dto\EventDto;
use App\Infrastructure\RedisIndexFactory;
use App\Infrastructure\Repository\EventRepository;
use Ehann\RedisRaw\RedisClientAdapter;

require_once __DIR__ . '/../vendor/autoload.php';

$client = new RedisClientAdapter();
$client->connect('redis');

$redisIndexFactory = new RedisIndexFactory($client);
$index = $redisIndexFactory->create();

$app = new App(new EventRepository($index));

$events = json_decode(file_get_contents(__DIR__ . '/events.json'), true);

foreach ($events as $event) {
    $eventDto = new EventDto($event['priority'], $event['name']);
    $conditionsDto = new ConditionsDto($event['conditions']);

    try {
        $app->createEvent($eventDto, $conditionsDto);
    } catch (Exception $e) {
        throw new Exception($e->getMessage());
    }
}

$conditionsDto = new ConditionsDto(['param1' => 1, 'param2' => 2]);

try {
    $event = $app->getEvent($conditionsDto);
} catch (Exception $e) {
    throw new Exception($e->getMessage());
}

var_dump($event);
$index->drop();
