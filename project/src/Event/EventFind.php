<?php

declare(strict_types=1);

namespace Vp\App\Event;

use Vp\App\DTO\Message;
use Vp\App\Exceptions\FindEventFailed;
use Vp\App\Models\Event;
use Vp\App\Result\ResultFind;
use Vp\App\Storage\StorageInterface;
use Vp\App\Storage\StorageManager;
use WS\Utils\Collections\Collection;

class EventFind
{
    use StorageManager;

    private StorageInterface $storage;

    public function __construct()
    {
        $this->storage = $this->getStorage();
    }
    public function work(FindParams $findParams): ResultFind
    {
        try {
            /** @var Collection $events */
            $events = $this->storage->find($findParams->getParams());

            if ($events->isEmpty()) {
                return new ResultFind(false, Message::EMPTY_EVENTS);
            }

            $eventsFiltered = $this->getEventsByConditions($findParams, $events);
            $priorityEvent = $this->getPriorityEvent($eventsFiltered);

            if (!$priorityEvent) {
                return new ResultFind(false, Message::EMPTY_EVENT);
            }

            $this->storage->delete($priorityEvent->getEventId());

            return new ResultFind(true, $priorityEvent->getEvent());
        } catch (FindEventFailed $e) {
            return new ResultFind(false, $e->getMessage());
        }
    }

    private function getEventsByConditions(FindParams $findParams, Collection $events): Collection
    {
        return $events->stream()->filter(
            static function (Event $event) use ($findParams): bool {
                $result = array_diff($event->getConditions(), $findParams->getParams());
                return count($result) < 1;
            }
        )->getCollection();
    }

    private function getPriorityEvent(Collection $eventsFiltered): ?Event
    {
        if ($eventsFiltered->isEmpty()) {
            return null;
        }

        $sortedEvents = [];

        foreach ($eventsFiltered as $event) {
            $sortedEvents[$event->getPriority()] = $event;
        }

        krsort($sortedEvents);
        return array_shift($sortedEvents);
    }
}
