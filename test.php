<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Dimal\Hw12\Event;
use Dimal\Hw12\EventConditions;
use Dimal\Hw12\RedisEventStorage;

$conf = parse_ini_file(".env");

$redis = new Redis();
$redis->connect($conf['REDIS_HOST'], (int)$conf['REDIS_PORT']);
$redis->select((int)$conf['REDIS_DB']);

$storage = new RedisEventStorage($redis);
$storage->clearEvents();

$event = new Event(
    new EventConditions(['param1' => '1']),
    '::event::',
    1000
);
$storage->addEvent($event);

$event = new Event(
    new EventConditions(['param1' => '1', 'param2' => '2']),
    '::event::',
    2000
);
$storage->addEvent($event);

$event = new Event(
    new EventConditions(['param1' => '1', 'param2' => '2']),
    '::event::',
    3000
);
$storage->addEvent($event);

$search_cond = new EventConditions(['param1' => '1', 'param2' => '2']);

$event = $storage->searchEvent($search_cond);
var_dump($event);
