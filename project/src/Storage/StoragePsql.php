<?php

namespace Vp\App\Storage;

use Exception;
use Vp\App\DTO\Message;
use Vp\App\Exceptions\AddEventFailed;
use Vp\App\Exceptions\FindEventFailed;
use Vp\App\Models\Event;
use Vp\App\Storage\Connections\ConnectionPsql;
use WS\Utils\Collections\Collection;
use WS\Utils\Collections\CollectionFactory;

class StoragePsql implements StorageInterface
{
    private const TABLE_NAME = 'events';
    private \PDO $conn;

    public function __construct()
    {
        $this->conn = ConnectionPsql::getInstance()->getConnection();
    }

    /**
     * @throws AddEventFailed
     */
    public function add(string $eventId, string $params, string $event): void
    {
        try {
            $this->createTable();
            $sql = 'INSERT INTO ' . self::TABLE_NAME . ' (event_id, event, params) VALUES(:event_id, :event, :params)';
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':event_id', 'event:' . $eventId);
            $stmt->bindValue(':event', $event);
            $stmt->bindValue(':params', $params);
            $stmt->execute();
        } catch (Exception $e) {
            throw new AddEventFailed(Message::FAILED_CREATE_EVENT . ': ' . $e->getMessage());
        }
    }

    /**
     * @throws FindEventFailed
     */
    public function find(array $eventParams): ?Collection
    {
        $sql = "SELECT event_id, params, event FROM " . self::TABLE_NAME . " WHERE";

        foreach ($eventParams as $param) {
            $sql .= " (params LIKE '%" . $param . "%') OR";
        }

        $sql = rtrim($sql, 'OR');

        $list = [];

        try {
            foreach ($this->conn->query($sql) as $row) {
                $event['event_id'] = $row['event_id'];
                $event['params'] = $row['params'];
                $event['event'] = $row['event'];
                $list[] = $event;
            }

            if (count($list) < 1) {
                return null;
            }

            $events = $this->getEvents($list);

            if (count($events) < 1) {
                return null;
            }

            return $this->createCollection($events);
        } catch (Exception $e) {
            throw new FindEventFailed(Message::FAILED_CREATE_EVENT . ': ' . $e->getMessage());
        }
    }

    private function getEvents(array $list): array
    {
        $events = [];

        foreach ($list as $item) {
            $event = json_decode($item['event'], true);
            $event['id'] = $item['event_id'];
            $events[] = $event;
        }
        return $events;
    }

    private function createCollection(array $events): Collection
    {
        return CollectionFactory::from($events)->stream()->map(
            function ($event) {
                return new Event($event['id'], $event['priority'], $event['conditions'], $event['event']);
            }
        )->getCollection();
    }

    public function delete(string $eventId): void
    {
        $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE event_id='" . $eventId . "'";
        $this->conn->query($sql);
    }

    private function createTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS " . self::TABLE_NAME . " (
                        id serial PRIMARY KEY,
                        event_id VARCHAR(50) NOT NULL,
                        event VARCHAR(256) NOT NULL,
                        params VARCHAR(256) NOT NULL
                        )";
        $this->conn->exec($sql);
    }
}
