<?php

require __DIR__ . "/../vendor/autoload.php";

use VKorabelnikov\Hw15\EventsManager\Application\Storage\EventsStorageFabric;
use VKorabelnikov\Hw15\EventsManager\Infrastructure\IniConfig;
use VKorabelnikov\Hw15\EventsManager\Domain\Model\Event;



try {
    $storagesFabric = new EventsStorageFabric();
    $obEventsStorage = $storagesFabric->getStorage("Redis", new IniConfig());

    $obEventsStorage->add(
        new Event(
            "::event1::",
            1000,
            [
                "param1" => 1
            ]
        )
    );

    $obEventsStorage->add(
        new Event(
            "::event2::",
            2000,
            [
                "param1" => 2,
                "param2" => 2
            ]
        )
    );

    $obEventsStorage->add(
        new Event(
            "::event3::",
            3000,
            [
                "param1" => 1,
                "param2" => 2
            ]
        )
    );

    $event = $obEventsStorage->getByCondition(
        [
            "param1" => 1,
            "param2" => 2
        ]
    );

    var_dump($event);
} catch (\Exception $e) {
    echo $e->getMessage();
}
