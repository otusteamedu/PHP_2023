<?php

declare(strict_types=1);

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\JsonSource;
use CuyZ\Valinor\Mapper\Tree\Message\Messages;
use CuyZ\Valinor\MapperBuilder;
use Twent\Hw12\DTO\Event;

require_once __DIR__ . '/../bootstrap/app.php';

$redis = new Redis();
$redis->pconnect($_ENV['REDIS_MASTER_HOST'], (int) $_ENV['REDIS_PORT_NUMBER']);
$redis->auth($_ENV['REDIS_PASSWORD']);

$redis->flushDB();

$data = '{
    "priority": 10,
    "conditions": {
        "param1": "Value1",
        "param2": "Value2",
        "param3": "Value3"
    },
    "data": {
        "title": "Event 1",
        "date": "2023-03-12 12:10:10",
        "description": "Event description 1"
    }
}';

try {
    $event = (new MapperBuilder())
        ->supportDateFormats(
            'd-m-Y H:i:s',
            'Y-m-d H:i:s',
            DATE_COOKIE,
            DATE_RFC3339,
            DATE_ATOM
        )
        ->mapper()
        ->map(
            Event::class,
            new JsonSource($data)
        );

    $eventData = toArray($event);

    $redis->hMSet('event:1', $eventData['data']);

    $redis->hMSet('conditions:event:1', $eventData['conditions']);
    // all keys for events
    dump($redis->keys('event*'));
    // get data for event 1
    dump($redis->hGetAll('event:1'));
    dump($redis->hGetAll('conditions:event:1'));

    $redis->zAdd('priority', ['NX'], $event->priority, 'event:1');

    // Кол-во элементов в множестве
    dump($redis->zCard('priority'));
    // Место элемента в множестве
    dump($redis->zRank('priority', 'event:1'));
    $item = $redis->zRange('priority', 0, 10, true);
    //$key = array_flip($key);
    dump(array_search($event->priority, $item));
    //dump($redis->zCount('events', '1', '10'));
} catch (MappingError $error) {
    $messages = Messages::flattenFromNode($error->node());

    foreach ($messages->errors() as $message) {
        $message = $message->withBody("Field {node_path} {original_message}<br>");
        echo $message;
    }
}
