<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Storage\redis\RedisStorage;
use Ehann\RediSearch\Exceptions\FieldNotInSchemaException;

try {
    $storage = new RedisStorage('events');
    $storage->set(1000, ['param1' => 1, 'param2' => 2], 'event1');
    $storage->set(2000, ['param1' => 3, 'param2' => 4], 'event2');
    $storage->set(3000, ['param1' => 1, 'param2' => 2], 'event3');

    print_r($storage->get(['param1' => 2, 'param2' => 2]));
} catch (FieldNotInSchemaException $e) {
    echo $e->getMessage();
}
