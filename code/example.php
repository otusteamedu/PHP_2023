<?php

require __DIR__ . "/../vendor/autoload.php";

use VKorabelnikov\Hw12\EventsManager\Application;

try {
    $app = new Application();
    $obEventsStorage = $app->getStorage("redis");

    $obEventsStorage->add(
        [
            "priority" => 1000,
            "conditions" => [
                "param1" => 1
            ],
            "event" => "::event1::"
        ]
    );

    $obEventsStorage->add(
        [
            "priority" => 2000,
            "conditions" => [
                "param1" => 2,
                "param2" => 2
            ],
            "event" => "::event2::"
        ]
    );

    $obEventsStorage->add(
        [
            "priority" => 3000,
            "conditions" => [
                "param1" => 1,
                "param2" => 2
            ],
            "event" => "::event3::"
        ]
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
