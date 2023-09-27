<?php

namespace IilyukDmitryi\App\Infrastructure\Storage\Mysql;

use Exception;
use IilyukDmitryi\App\Application\Contract\Storage\EventStorageInterface;
use IilyukDmitryi\App\Application\Dto\Event;
use IilyukDmitryi\App\Infrastructure\Storage\Mysql\Entity\EventMapper;
use PDO;

class EventStorage implements EventStorageInterface
{
    private EventMapper $eventMapper;

    public function __construct(PDO $pdo)
    {
        $tableExists = $this->checkTableEventExist($pdo);
        if (!$tableExists) {
            $this->createTable($pdo);
        }
        $tableExists = $this->checkTableEventExist($pdo);
        if (!$tableExists) {
            throw Exception("No Create Table `event` ");
        }
        $this->eventMapper = new EventMapper($pdo);
    }

    /**
     * @param PDO $pdo
     * @return bool
     */
    private function checkTableEventExist(PDO $pdo): bool
    {
        $sql = "SHOW TABLES LIKE :table_name";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':table_name', EventMapper::TABLE_NAME);
        $stmt->execute();
        $tableExists = $stmt->rowCount() > 0;
        return $tableExists;
    }

    /**
     * @param $pdo
     * @return void
     */
    private function createTable($pdo): void
    {
        $sql = "CREATE TABLE `event` (
  `uuid` varchar(23) COLLATE 'utf8_general_ci' NOT NULL PRIMARY KEY,
  `params` text COLLATE 'utf8_general_ci' NOT NULL,
  `done` bool DEFAULT FALSE,
  `creation_time` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `done_time` DATETIME null
) COMMENT='' ENGINE='InnoDB' COLLATE 'utf8_general_ci';";
        //TODO: добавить индекс по uuid
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }

    /**
     * @param array $arrEvents
     * @return int
     * @throws Exception
     */
    public function add(Event $event): bool
    {
        $uuid = $event->getUuid();
        if ($this->eventMapper->getByUUID($event->getUuid())) {
            throw new Exception("Event $uuid already exists");
        }

        $eventEntity = EventMapper::rawToEvent($event->toArray());
        $eventBd = $this->eventMapper->insert($eventEntity);
        return (bool)$eventBd->getUuid();
    }


    /**
     * @param string $uuid
     * @return int
     * @throws Exception
     */
    public function delete(string $uuid): bool
    {
        $event = $this->eventMapper->getByUUID($uuid);
        if (is_null($event)) {
            throw new Exception("No exist event uuid = $uuid");
        }
        return $this->eventMapper->delete($event);
    }

    public function list(int $limit = 0): array
    {
        $arrEvents = [];
        $collection = $this->eventMapper->list($limit);
        foreach ($collection as $event) {
            $raw = EventMapper::eventToRaw($event);
            if ($raw) {
                $arrEvents[] = $raw;
            }
        }
        return $arrEvents;
    }

    /**
     * @param string $uuid
     * @return Event
     * @throws Exception
     */
    public function get(string $uuid): Event
    {
        $evenrBd = $this->eventMapper->getByUUID($uuid);
        if (!$evenrBd) {
            throw new Exception("Event $uuid not found in event collection");
        }
        $event = new Event($evenrBd->getUuid(), $evenrBd->getParams(), $evenrBd->isDone());
        return $event;
    }

    /**
     * @param $uuid
     * @return bool
     */
    public function setDone($uuid): bool
    {
        return true;
    }
}
