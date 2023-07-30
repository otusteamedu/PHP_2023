<?php

namespace IilyukDmitryi\App\Storage\Redis\Entity;

use IilyukDmitryi\App\Storage\Base\EventStorageInterface;

class EventStorage extends Base implements EventStorageInterface
{
    /**
     * @param array $arrEvents
     * @return bool
     */
    public function add(array $arrEvents): int
    {
        $priority = $arrEvents['priority'];
        $res = $this->client->zadd('events', $priority, json_encode($arrEvents));
        return $res;
    }

    /**
     * @return bool
     */
    public function deleteAll(): int
    {
        $res = $this->client->del('events');
        return $res;
    }

    /**
     * @param array $arrParams
     * @return array
     */
    public function findTopByParams(array $arrParams): array
    {
        $events = $this->client->zrevrangebyscore('events', '+inf', 0);
        $topEvent = [];
        if ($events) {
            foreach ($events as $event) {
                $eventData = json_decode($event, true);
                if ($arrParams === $eventData['params']) {
                    $topEvent = $eventData;
                    break;
                }
            }
        }
        return $topEvent;
    }

    public function list(): array
    {
        $events = $this->client->zrevrangebyscore('events', '+inf', 0) ?? [];
        $arrEvents = [];
        if ($events) {
            foreach ($events as $event) {
                $eventData = json_decode($event, true);
                if (is_array($eventData)) {
                    $arrEvents[] = $eventData;
                }
            }
        }
        return $arrEvents;
    }
}
