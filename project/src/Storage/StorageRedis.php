<?php

declare(strict_types=1);

namespace Vp\App\Storage;

use Vp\App\DTO\Message;
use Vp\App\Exceptions\AddEventFailed;
use Vp\App\Exceptions\FindEventFailed;
use Vp\App\Models\Event;
use Vp\App\Storage\Connections\ConnectionRedis;
use WS\Utils\Collections\Collection;
use WS\Utils\Collections\CollectionFactory;

class StorageRedis implements StorageInterface
{
    private const INDEX_NAME = 'event_index';

    private \Redis $conn;

    public function __construct()
    {
        $this->conn = ConnectionRedis::getInstance()->getConnection();
    }

    /**
     * @throws AddEventFailed
     */
    public function add(string $eventId, string $params, string $event): void
    {
        try {
            if (
                ($this->conn->hSet('event:' . $eventId, 'params', $params) === false) ||
                ($this->conn->hSet('event:' . $eventId, 'event', $event) === false)
            ) {
                throw new AddEventFailed(Message::FAILED_CREATE_EVENT);
            }
            $this->createIndex();
        } catch (\RedisException $e) {
            throw new AddEventFailed(Message::FAILED_CREATE_EVENT . ': ' . $e->getMessage());
        }
    }

    /**
     * @throws \RedisException
     */
    private function createIndex()
    {
        $indexes = $this->conn->rawCommand('FT._LIST');
        if (!is_array($indexes) || !in_array(self::INDEX_NAME, $indexes)) {
            $this->conn->rawCommand('FT.CREATE', self::INDEX_NAME, 'prefix', '1', 'event:', 'SCHEMA', 'params', 'TEXT');
        }
    }

    /**
     * @throws FindEventFailed
     */
    public function find(array $eventParams): ?Collection
    {
        $findParams = trim(implode('|', $eventParams), '|');

        try {
            $result = $this->conn->rawCommand('FT.SEARCH', self::INDEX_NAME, $findParams);

            if (!is_array($result)) {
                return null;
            }

            $events = $this->getEvents($result);

            if (count($events) < 1) {
                return null;
            }

            return $this->createCollection($events);
        } catch (\RedisException $e) {
            throw new FindEventFailed(Message::FAILED_CREATE_EVENT . ': ' . $e->getMessage());
        }
    }

    public function delete(string $eventId): void
    {
        $this->conn->del($eventId);
    }

    private function getEvents(array $result): array
    {
        $events = [];
        array_shift($result);
        $eventsList = array_chunk($result, 2);

        foreach ($eventsList as $eventChunk) {
            $eventId = $eventChunk[0];
            $event = $this->getEvent($eventChunk[1]);
            $event['id'] = $eventId;
            $events[] = $event;
        }
        return $events;
    }

    private function getEvent(array $eventItems): array
    {
        for ($i = 0; $i < count($eventItems); $i++) {
            $item = $eventItems[$i];

            if ($item == 'event') {
                $eventJson = $eventItems[$i + 1];
                return json_decode($eventJson, true);
            }
        }
        return [];
    }

    private function createCollection(array $events): Collection
    {
        return CollectionFactory::from($events)->stream()->map(
            function ($event) {
                return new Event($event['id'], $event['priority'], $event['conditions'], $event['event']);
            }
        )->getCollection();
    }
}
