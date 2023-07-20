<?php

namespace App\Controller;

use App\Model\EventSystem;

class EventController
{
    private $eventSystem;

    public function __construct(EventSystem $eventSystem)
    {
        $this->eventSystem = $eventSystem;
    }

    public function addAction($priority, $conditions, $event)
    {
        $this->eventSystem->addEvent($priority, $conditions, $event);
        echo "Event added successfully.";
    }

    public function clearAction()
    {
        $this->eventSystem->clearEvents();
        echo "All events cleared.";
    }

    public function findMatchingAction($params)
    {
        $matchingEvent = $this->eventSystem->findMatchingEvent($params);
        if ($matchingEvent !== null) {
            echo "Matching event: " . $matchingEvent->getEvent();
        } else {
            echo "No matching event found.";
        }
    }
}
