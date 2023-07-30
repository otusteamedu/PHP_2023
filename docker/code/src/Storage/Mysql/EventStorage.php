<?php

namespace IilyukDmitryi\App\Storage\Mysql;

use Exception;
use IilyukDmitryi\App\Storage\Base\EventStorageInterface;
use IilyukDmitryi\App\Storage\Mysql\Entity\EventMapper;
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
            throw \Exception("No Create Table `event` ");
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
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `event` text COLLATE 'utf8_general_ci' NOT NULL,
  `priority` int NOT NULL,
  `params` text COLLATE 'utf8_general_ci' NOT NULL
) COMMENT='' ENGINE='InnoDB' COLLATE 'utf8_general_ci';";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    }
    
    /**
     * @param array $arrEvents
     * @return int
     * @throws Exception
     */
    public function add(array $arrEvents): int
    {
        if ($this->eventMapper->getByEvent($arrEvents['event'])) {
            return 0;
        }
        
        $event = EventMapper::rawToEvent($arrEvents);
        $eventBd = $this->eventMapper->insert($event);
        if (is_null($eventBd)) {
            return 0;
        }
        return 1;
    }
    
    
    /**
     * @return int
     */
    public function deleteAll(): int
    {
        return $this->eventMapper->deleteAll() ? 1 : 0;
    }
    
    /**
     * @param array $arrParams
     * @return array
     */
    public function findTopByParams(array $arrParams): array
    {
        $topEvent = [];
        $event = $this->eventMapper->findTopByParams($arrParams);
        if (!is_null($event)) {
            $topEvent = EventMapper::eventToRaw($event);
        }
        return $topEvent;
    }
    
    public function list(): array
    {
        $arrEvents = [];
        $collection = $this->eventMapper->list();
        foreach ($collection as $event) {
            $raw = EventMapper::eventToRaw($event);
            if ($raw) {
                $arrEvents[] = $raw;
            }
        }
        return $arrEvents;
    }
}
