<?php

use App\Factory\RedisIndexFactory;
use App\Storage\RedisStorage;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $redisIndexFactory = new RedisIndexFactory();
    $redisStorage = new RedisStorage($redisIndexFactory->create());
    $events = json_decode(file_get_contents(__DIR__ . '/events.json'), true);

    foreach ($events as $event) {
        $redisStorage->add($event['priority'], $event['name'], $event['conditions']);
    }

    print_r($redisStorage->get(['param1' => 1, 'param2' => 2]));

    $redisStorage->clear();
} catch (Exception $e) {
    print_r($e->getMessage());
}
