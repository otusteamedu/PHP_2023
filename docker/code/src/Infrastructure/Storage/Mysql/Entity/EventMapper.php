<?php

namespace IilyukDmitryi\App\Infrastructure\Storage\Mysql\Entity;

use Exception;
use PDO;
use PDOStatement;

class EventMapper
{
    public const TABLE_NAME = 'event';
    private PDO $pdo;
    private PDOStatement $insertStmt;
    private PDOStatement $deleteStmt;
    private PDOStatement $listStmt;
    private PDOStatement $getByIdStmt;
    private PDOStatement $getByUUIDStmt;
    private PDOStatement $updateStmt;
    private IdentityMap $identityMap;

    public function __construct(
        PDO $pdo,
    ) {
        $this->pdo = $pdo;

        $this->insertStmt = $this->pdo
            ->prepare(
                'INSERT INTO ' . static::TABLE_NAME . ' (uuid, params,done) VALUES (:uuid, :params, :done)'
            );

        $this->deleteStmt = $this->pdo
            ->prepare('DELETE FROM ' . static::TABLE_NAME . ' WHERE uuid = :uuid');

        $this->listStmt = $this->pdo
            ->prepare('SELECT * FROM ' . static::TABLE_NAME . ' ORDER BY `date` ASC LIMIT :limit');

        $this->getByIdStmt = $this->pdo
            ->prepare('SELECT * FROM ' . static::TABLE_NAME . ' WHERE uuid = :uuid');

        $this->getByUUIDStmt = $this->pdo
            ->prepare('SELECT * FROM ' . static::TABLE_NAME . ' WHERE uuid = :uuid');

        $this->updateStmt = $this->pdo
            ->prepare(
                'UPDATE ' . static::TABLE_NAME . ' SET uuid = :uuid, params=:params, done=:done WHERE id=:id'
            );


        $this->identityMap = new IdentityMap();
    }

    /**
     * @param Event $event
     * @return array
     */
    public static function eventToRaw(Event $event): array
    {
        return [
            'uuid' => $event->getUuid(),
            'params' => $event->getParams(),
            'done' => $event->isDone(),
        ];
    }

    /**
     * @param Event $event
     * @return bool
     */
    public function delete(Event $event): bool
    {
        $this->deleteStmt->execute(['uuid' => $event->getUuid()]);
        return $this->deleteStmt->rowCount()===1;
    }

    /**
     * @param Event $event
     * @return Event|null
     * @throws Exception
     */
    public function insert(Event $event): ?Event
    {
        $this->insertStmt->execute([
            'uuid' => $event->getUuid(),
            'params' => json_encode($event->getParams(), JSON_UNESCAPED_UNICODE),
            'done' => $event->isDone(),
        ]);
        $uuid = $event->getUuid();
        $eventBd = $this->getByUUID($uuid);

        if (null === $eventBd) {
            throw new Exception('event no exist');
        }
        return $event;
    }


    /**
     * @param $arrFields
     * @return Event
     */
    public static function rawToEvent($arrFields): Event
    {
        return (new Event())
            ->setUuid($arrFields['uuid'] ?? 0)
            ->setParams($arrFields['params'] ?? [])
            ->setDone($arrFields['done'] ?? false);
    }


    /**
     * @param string $eventName
     * @return Event|null
     */
    public function getByUUID(string $uuid): ?Event
    {
        $this->getByUUIDStmt->bindValue(':uuid', $uuid);
        $this->getByUUIDStmt->execute();
        $raw = $this->getByUUIDStmt->fetch();
        if ($raw) {
            return static::rawToEvent($raw);
        }
        return null;
    }

    /**
     * @return array
     */
    public function list(): array
    {
        $this->listStmt->execute();
        $arrEvents = $this->listStmt->fetchAll();
        $collection = [];
        foreach ($arrEvents as $event) {
            $objEvent = static::rawToEvent($event);
            $this->identityMap->set($objEvent->getUuid(), $objEvent);
            $collection[] = $objEvent;
        }
        return $collection;
    }
}
