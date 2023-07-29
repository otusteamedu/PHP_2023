<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw15\EventsManager\Domain\Model;

use VKorabelnikov\Hw15\EventsManager\Domain\ValueObject\Priority;
use VKorabelnikov\Hw15\EventsManager\Domain\ValueObject\ConditionList;
use VKorabelnikov\Hw15\EventsManager\Domain\ValueObject\EventTitle;

class Event
{
    private Priority $priority;
    private EventTitle $eventTitle;
    private ConditionList $conditions;

    public function __construct(EventTitle $eventTitle, Priority $priority, ConditionList $conditions)
    {
        $this->eventTitle = $eventTitle;
        $this->priority = $priority;
        $this->conditions = $conditions;
    }

    public function getPriority(): Priority
    {
        return $this->priority;
    }

    public function getEventTitle(): EventTitle
    {
        return $this->eventTitle;
    }

    public function getConditions(): ConditionList
    {
        return $this->conditions;
    }
}
