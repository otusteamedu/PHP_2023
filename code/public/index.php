<?php

require __DIR__ . "/../vendor/autoload.php";

use VKorabelnikov\Hw15\EventsManager\Application\Storage\EventsStorageFabric;
use VKorabelnikov\Hw15\EventsManager\Infrastructure\IniConfig;
use VKorabelnikov\Hw15\EventsManager\Domain\Model\Event;

use VKorabelnikov\Hw15\EventsManager\Domain\ValueObject\Priority;
use VKorabelnikov\Hw15\EventsManager\Domain\ValueObject\ConditionList;
use VKorabelnikov\Hw15\EventsManager\Domain\ValueObject\EventTitle;



try {
    $obEventsStorage = EventsStorageFabric::getStorage("Redis", new IniConfig());

    $obEventsStorage->add(
        new Event(
            new EventTitle("::event1::"),
            new Priority(1000),
            new ConditionList(
                [
                    "param1" => 1
                ]
            )
        )
    );

    $obEventsStorage->add(
        new Event(
            new EventTitle("::event2::"),
            new Priority(2000),
            new ConditionList(
                [
                    "param1" => 2,
                    "param2" => 2
                ]
            )
        )
    );

    $obEventsStorage->add(
        new Event(
            new EventTitle("::event3::"),
            new Priority(3000),
            new ConditionList(
                [
                    "param1" => 1,
                    "param2" => 2
                ]
            )
        )
    );

    $event = $obEventsStorage->getByCondition(
        new ConditionList(
            [
                "param1" => 1,
                "param2" => 2
            ]
        )
    );

    var_dump($event->getValue());
} catch (\Exception $e) {
    echo $e->getMessage();
}
