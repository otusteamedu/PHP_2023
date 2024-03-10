<?php

declare(strict_types=1);

namespace RedisApp\App;

use Predis\Client;
use RedisApp\EventStorage\RedisEventStorage;
use RedisApp\Event\Event;
use App\EventSystem\EventSystem;

final class App
{
    public function run()
    {

        $redis = new Client();
        $eventStorage = new RedisEventStorage($redis);
        $eventSystem = new EventSystem($eventStorage);

        $eventSystem->addEvent(new Event(1000, ['param1' => 1], ['event' => '::event::']));
        $eventSystem->addEvent(new Event(2000, ['param1' => 2, 'param2' => 2], ['event' => '::event::']));
        $eventSystem->addEvent(new Event(3000, ['param1' => 1, 'param2' => 2], ['event' => '::event::']));

        $userParams = ['param1' => 1, 'param2' => 2];
        $matchingEvent = $eventSystem->findMatchingEvent($userParams);

        if ($matchingEvent) {
            echo "Matching event found with priority {$matchingEvent->priority}\n";
        } else {
            echo "No matching event found\n";
        }

    }
}