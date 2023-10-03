<?php

use App\Event\EventSystem;
use App\Storage\RedisStorage;

require_once __DIR__ . '/vendor/autoload.php';

$eventSystem = new EventSystem(new RedisStorage());

// Добавление событий
$eventSystem->addEvent(
    1000,
    ['param1' => 1],
    '::event1::'
);

$eventSystem->addEvent(
    2000,
    ['param1' => 2, 'param2' => 2],
    '::event2::'
);

$eventSystem->addEvent(
    3000,
    ['param1' => 1, 'param2' => 2],
    '::event3::'
);

// Получение события
$event = $eventSystem->getEvent(['param1' => 1, 'param2' => 2]);

echo $event . PHP_EOL;