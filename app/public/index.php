<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\EventSystem;
use App\Storage\RedisStorage;

try {
    $storage = new RedisStorage($_ENV['REDIS_HOST'], $_ENV['INDEX_NAME']);
    $eventSystem = new EventSystem($storage);

    // Добавляем в хранилище события
    $eventSystem->addEvent(2000, ['param1' => 2, 'param2' => 2], 'event2');
    $eventSystem->addEvent(4000, ['param1' => 1, 'param2' => 2], 'event3');
    $eventSystem->addEvent(3000, ['param1' => 1, 'param2' => 2], 'event4');

    // Извлекаем из хранилища событие по параметрам
    print_r($eventSystem->getEvent(['param1' => 1, 'param2' => 2]));

    // Удаляем события (индекс)
    $eventSystem->clearEvents();
} catch (Exception $e) {
    print_r($e->getMessage());
}
