<?php

declare(strict_types=1);

use Khalikovdn\Hw12\Event;
use Khalikovdn\Hw12\Services\RedisStorageService;

require __DIR__ . '/vendor/autoload.php';

try {
    $event = new Event(new RedisStorageService());
    echo $event->getMostSuitableEvent(['param1' => 1, 'param2' => 2]);
} catch (Exception $e) {
    throw new \Exception($e->getMessage());
}