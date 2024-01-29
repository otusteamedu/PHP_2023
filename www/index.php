<?php

declare(strict_types=1);

use KhalikovDn\Hw12\Services\RedisStorageService;

require __DIR__ . '/vendor/autoload.php';

$redisStorageService = new RedisStorageService();

$redisStorageService->add(1000, ['param1' => 1], ['event' => '::event1::']);
$redisStorageService->add(2000, ['param1' => 2, 'param2' => 2], ['event' => '::event2::']);
$redisStorageService->add(3000, ['param1' => 1, 'param2' => 2], ['event' => '::event3::']);

$userQuery = ['param1' => 1, 'param2' => 2];

$matchingEvent = $redisStorageService->get($userQuery);

if ($matchingEvent) {
    echo "Наиболее подходящее событие: " . json_encode($matchingEvent) . PHP_EOL;
} else {
    echo "Нет подходящих событий." . PHP_EOL;
}