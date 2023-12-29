<?php

namespace App\Application\Helper;

use App\Application\Action\AddEvent\AddEventEventAction;
use App\Application\Action\ClearAllEvents\ClearAllEventsEventAction;
use App\Application\Action\EventActionInterface;
use App\Application\Action\GetFirstPrioritizedEvent\GetFirstPrioritizedEventAction;
use App\Application\Action\InitEvents\InitEventsEventAction;

class EventActionByArgument
{
    public function get(array $arguments): EventActionInterface
    {
        $actions = [
            'init' => InitEventsEventAction::class,
            'add' => AddEventEventAction::class,
            'get' => GetFirstPrioritizedEventAction::class,
            'clr' => ClearAllEventsEventAction::class,
        ];

        $argument = $arguments[1];
        if (!isset($actions[$argument])) {
            throw new \RuntimeException('Error: Unexpected arguments.');
        }

        return new $actions[$argument]($arguments);
    }
}
