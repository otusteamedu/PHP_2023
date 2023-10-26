<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Storage\redis\RedisStorage;
use Ehann\RediSearch\Exceptions\FieldNotInSchemaException;

try {
    $storage = new RedisStorage('localhost', 'events');
    $storage->set(2000, ['param1' => 2, 'param2' => 2], 'event2');

    print_r($storage->get(['param1' => 2, 'param2' => 2]));
    $storage->clear();
} catch (FieldNotInSchemaException $e) {
    echo $e->getMessage();
}


