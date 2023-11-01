<?php

declare(strict_types=1);

namespace Gesparo\HW\Request;

use Gesparo\HW\Event\Event;
use Gesparo\HW\Event\EventList;
use Symfony\Component\HttpFoundation\Request;

class AddRequest
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @throws \JsonException
     */
    public function getEvents(): EventList
    {
        $events = json_decode($this->request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        if (!is_array($events)) {
            throw new \InvalidArgumentException('you should pass array of events');
        }

        $result = [];

        foreach ($events as $event) {
            $result[] = new Event($event);
        }

        return new EventList($result);
    }
}