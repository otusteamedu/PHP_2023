<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\EventSystem;
use App\Storage\RedisStorage;

try {
    $storage = new RedisStorage($_ENV['REDIS_KEY'], $_ENV['REDIS_HOST']);
    $eventSystem = new EventSystem($storage);

    // Добавляем в хранилище события
    $eventSystem->addEvent(1000, ['param1' => 1], 'event1');
    $eventSystem->addEvent(4000, ['param1' => 1], 'event11');
    $eventSystem->addEvent(2000, ['param1' => 2, 'param2' => 2], 'event2');
    $eventSystem->addEvent(3000, ['param1' => 1, 'param2' => 2], 'event3');

    // Извлекаем из хранилища событие по параметрам
    echo $eventSystem->getEvent(['param1' => 1, 'param2' => 2]) . PHP_EOL;
} catch (Exception $e) {
    echo $e->getMessage();
}
