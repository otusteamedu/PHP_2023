<?php

namespace IilyukDmitryi\App\Infrastructure\Storage\Mysql\Repository;

use IilyukDmitryi\App\Domain\Entity\Event;
use IilyukDmitryi\App\Domain\Model\EventModel;
use IilyukDmitryi\App\Domain\Repository\EventRepositoryInterface;
use IilyukDmitryi\App\Domain\ValueObject\Currency;
use PDO;
use PDOStatement;

class EventRepository implements EventRepositoryInterface
{
    public const TABLE_NAME = 'event';
    private PDO $pdo;
    private PDOStatement $insertStmt;
    private PDOStatement $getByIdStmt;
    private PDOStatement $updateStmt;
    private PDOStatement $deleteByIdStmt;
    
    private ?IdentityMap $identityMap = null;
    
    public function __construct(
        PDO $pdo,
    ) {
        $this->identityMap = new IdentityMap();
        $this->pdo = $pdo;
        $this->insertStmt = $this->pdo
            ->prepare(
                'INSERT INTO '.static::TABLE_NAME.' (id, name) VALUES (:id, :name)'
            );
        
        $this->updateStmt = $this->pdo
            ->prepare(
                ' UPDATE '.static::TABLE_NAME.' SET name = :name WHERE id=:id'
            );
        
        $this->listAllStmt = $this->pdo
            ->prepare('SELECT * FROM '.static::TABLE_NAME.' ORDER BY id DESC');
        
        $this->getByIdStmt = $this->pdo
            ->prepare('SELECT * FROM '.static::TABLE_NAME.' WHERE id = :id');
        
        $this->deleteByIdStmt = $this->pdo
            ->prepare('DELETE FROM '.static::TABLE_NAME.' WHERE id = :id');
        
    }
    
    /**
     * @param Event $event
     * @return array
     */
    public static function eventToRaw(Event $event): array
    {
        return [
            'id' => $event->getId(),
            'name' => $event->getName(),
        ];
    }
    
    /**
     * @param $arrFields
     * @return Event
     */
    public static function rawToEvent($arrFields): Event
    {
        return (new Event())
            ->setId($arrFields['id'] ?? 0)
            ->setName($arrFields['name'] ?? "");
    }
    
    
    public function getById(int $id): ?Event
    {
        if($object = $this->identityMap->get($id)){
            return $object;
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
    
    public function add(Event $event): int
    {
        $fields = self::eventToRaw($event);
        if($fields['id'] === 0){
            $fields['id'] = null;
        }
        $this->insertStmt->execute(self::eventToRaw($event));
        $id = (int)$this->pdo->lastInsertId();
        $event = $this->getById($id);
        
        if (null === $event) {
            throw new \Exception('event no exist');
        }
        return $id;
    }
    
    public function update(Event $event): void
    {
        $this->identityMap->remove($event->getId());
        $this->updateStmt->execute(self::eventToRaw($event));
        //$id = (int)$this->pdo->lastInsertId();
        $event = $this->getById($event->getId());
        
        if (null === $event) {
            throw new \Exception('event no exist');
        }
    }
    
    public function delete(int $id): void
    {
        if($this->deleteByIdStmt->execute(['id'=>$id])===false) {
            throw new \Exception('error delete event '.$id);
        }
    }
    
}