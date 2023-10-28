<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Application\Storage\redis\RedisStorage;
use App\Infrastructure\EventController;
use Ehann\RediSearch\Exceptions\FieldNotInSchemaException;

try {
    $storage = new RedisStorage('events');
    $eventController = new EventController($storage);

    $eventController->setEvent(1000, ['param1' => 1, 'param2' => 2], 'event1');
    $eventController->setEvent(2000, ['param1' => 3, 'param2' => 4], 'event2');
    $eventController->setEvent(3000, ['param1' => 1, 'param2' => 2], 'event3');

    print_r($eventController->getEvent(['param1' => 2, 'param2' => 2]));
} catch (FieldNotInSchemaException $e) {
    echo $e->getMessage();
}
