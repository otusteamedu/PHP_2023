<?php

namespace IilyukDmitryi\App\Infrastructure\Storage\Redis\Entity;

use IilyukDmitryi\App\Infrastructure\Storage\Base\EventStorageInterface;

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
        $strParams = implode(',', $arrParams);
        $events = $this->client->zrevrangebyscore('events', '+inf', 0);
        $topEvent = [];
        if ($events) {
            foreach ($events as $event) {
                $eventData = json_decode($event, true);
                if ($strParams === $eventData['params']) {
                    $eventData['params'] = explode(',', $eventData['params']);
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
                    $eventData['params'] = explode(',', $eventData['params']);
                    $arrEvents[] = $eventData;
                }
            }
        }
        return $arrEvents;
    }
}
