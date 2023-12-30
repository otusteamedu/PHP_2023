<?php

declare(strict_types=1);

use App\Domain\Entity\Event;
use App\Domain\ValueObject\Conditions;
use App\Infrastructure\RedisIndexFactory;
use App\Infrastructure\Repository\EventRepository;
use Ehann\RedisRaw\RedisClientAdapter;

require_once __DIR__ . '/../vendor/autoload.php';

$client = new RedisClientAdapter();
$client->connect('redis');

$redisFactory = new RedisIndexFactory($client);
$redisIndex = $redisFactory->create();

$repository = new EventRepository($redisIndex);

$events = json_decode(file_get_contents(__DIR__ . '/events.json'), true);

foreach ($events as $event) {
    $repository->add(new Event($event['name'], $event['priority'], new Conditions($event['conditions'])));
}

//$conditionSearch = new Conditions(['param1' => 1, 'param2' => 2]);
//$repository->get($conditionSearch);