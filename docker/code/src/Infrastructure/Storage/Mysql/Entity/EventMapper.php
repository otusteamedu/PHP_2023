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
    private PDOStatement $findTopByParamsStmt;
    private PDOStatement $deleteAllStmt;
    private PDOStatement $listAllStmt;
    private PDOStatement $getByIdStmt;
    private PDOStatement $getByEventStmt;
    
    private IdentityMap $identityMap;
    
    public function __construct(
        PDO $pdo,
    ) {
        $this->pdo = $pdo;
        
        $this->insertStmt = $this->pdo
            ->prepare(
                'INSERT INTO '.static::TABLE_NAME.' (event, priority, params) VALUES (:event, :priority, :params)'
            );
        
        $this->findTopByParamsStmt = $this->pdo
            ->prepare('SELECT * FROM '.static::TABLE_NAME.' WHERE params = :params ORDER BY priority DESC LIMIT 1');
        
        $this->deleteAllStmt = $this->pdo
            ->prepare('DELETE FROM '.static::TABLE_NAME);
        
        $this->listAllStmt = $this->pdo
            ->prepare('SELECT * FROM '.static::TABLE_NAME.' ORDER BY priority DESC');
        
        $this->getByIdStmt = $this->pdo
            ->prepare('SELECT * FROM '.static::TABLE_NAME.' WHERE id = :id');
        
        $this->getByEventStmt = $this->pdo
            ->prepare('SELECT * FROM '.static::TABLE_NAME.' WHERE event = :event');
        
        $this->identityMap = new IdentityMap();
    }
    
    /**
     * @param Event $event
     * @return array
     */
    public static function eventToRaw(Event $event): array
    {
        return [
            'id' => $event->getId(),
            'event' => $event->getEvent(),
            'priority' => $event->getPriority(),
            'params' => $event->getParams(),
        ];
    }
    
    /**
     * @return int
     */
    public function deleteAll(): int
    {
        $this->deleteAllStmt->execute();
        $this->identityMap->removeAll();
        return $this->deleteAllStmt->rowCount();
    }
    
    /**
     * @param Event $event
     * @return Event|null
     * @throws Exception
     */
    public function insert(Event $event): ?Event
    {
        $this->insertStmt->execute([
            'event' => $event->getEvent(),
            'priority' => $event->getPriority(),
            'params' => implode(',', $event->getParams()),
        ]);
        $id = (int)$this->pdo->lastInsertId();
        $event = $this->getByIdStmt($id);
        
        if (null === $event) {
            throw new Exception('event no exist');
        }
        return $event;
    }
    
    /**
     * @param int $id
     * @return Event|null
     */
    public function getByIdStmt(int $id): ?Event
    {
        if ($event = $this->identityMap->get($id)) {
            return $event;
        }
        
        $this->getByIdStmt->execute(['id' => $id]);
        $raw = $this->getByIdStmt->fetch();
        
        if ($raw) {
            $event = static::rawToEvent($raw);
            $this->identityMap->set($id, $event);
            return $event;
        }
        
        return null;
    }
    
    /**
     * @param $arrFields
     * @return Event
     */
    public static function rawToEvent($arrFields): Event
    {
        return (new Event())
            ->setId($arrFields['id'] ?? 0)
            ->setEvent($arrFields['event'] ?? '')
            ->setPriority($arrFields['priority'] ?? 0)
            ->setParams($arrFields['params'] ?? []);
    }
    
    /**
     * @param array $arrParams
     * @return Event|null
     */
    public function findTopByParams(array $arrParams): ?Event
    {
        $params = static::arrParamsToString($arrParams);
        if (!$params) {
            return null;
        }
        $this->findTopByParamsStmt->bindValue(':params', $params);
        $this->findTopByParamsStmt->execute();
        $raw = $this->findTopByParamsStmt->fetch();
        if ($raw) {
            return static::rawToEvent($raw);
        }
        return null;
    }
    
    /**
     * @param $arrParams
     * @return string
     */
    private static function arrParamsToString($arrParams): string
    {
        $params = [];
        foreach ($arrParams as $key => $param) {
            $param = trim($param);
            $param = (int)$param;
            if ($param > 0) {
                $params[] = $param;
            }
        }
        if (!$params) {
            return '';
        }
        return implode(',', $params);
    }
    
    /**
     * @param string $eventName
     * @return Event|null
     */
    public function getByEvent(string $eventName): ?Event
    {
        $this->getByEventStmt->bindValue(':event', $eventName);
        $this->getByEventStmt->execute();
        $raw = $this->getByEventStmt->fetch();
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
        $this->listAllStmt->execute();
        $arrEvents = $this->listAllStmt->fetchAll();
        $collection = [];
        foreach ($arrEvents as $event) {
            $objEvent = static::rawToEvent($event);
            $this->identityMap->set($objEvent->getId(), $objEvent);
            $collection[] = $objEvent;
        }
        return $collection;
    }
}
