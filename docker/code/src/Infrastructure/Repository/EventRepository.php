<?php

namespace IilyukDmitryi\App\Infrastructure\Repository;

use Exception;
use IilyukDmitryi\App\Application\Builder\EventModelBuilder;
use IilyukDmitryi\App\Application\Dto\CreateEventRequest;
use IilyukDmitryi\App\Domain\Model\EventModel;
use IilyukDmitryi\App\Domain\Repository\EventRepositoryInterface;
use IilyukDmitryi\App\Domain\ValueObject\Params;
use IilyukDmitryi\App\Infrastructure\Storage\Base\EventStorageInterface;
use IilyukDmitryi\App\Infrastructure\Storage\StorageApp;


class  EventRepository implements EventRepositoryInterface
{
    private ?EventStorageInterface $storage;
    
    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->initStorage();
    }
    
    /**
     * @throws Exception
     */
    public function initStorage(): void
    {
        $storageApp = StorageApp::get();
        $storage = $storageApp->getEventStorage();
        $this->storage = $storage;
    }
    
    /**
     * @param array $event
     * @return int
     */
    public function add(EventModel $eventModel): int
    {
        $raw = [
            'event' => $eventModel->getEvent()->getValue(),
            'priority' => $eventModel->getPriority()->getValue(),
            'params' => $eventModel->getParams()->getValueString(),
        ];
        return $this->storage->add($raw);
    }
    
    /**
     * @param int $eventId
     * @return int
     */
    public function deleteAll(): int
    {
        return $res = $this->storage->deleteAll();
    }
    
    public function findTopByParams(Params $params): ?EventModel
    {
        $eventRaw = $this->storage->findTopByParams($params->getValue());
        if ($eventRaw) {
            $createEventRequest = new CreateEventRequest(
                $eventRaw['event'],
                $eventRaw['priority'],
                $eventRaw['params'],
            );
            return EventModelBuilder::createFromRequest($createEventRequest);
        }
        return null;
    }
    
    public function list(): array
    {
        $arrEventModel = [];
        $eventsRaw = $this->storage->list();
        if ($eventsRaw) {
            foreach ($eventsRaw as $eventRaw) {
                $createEventRequest = new CreateEventRequest(
                    $eventRaw['event'],
                    $eventRaw['priority'],
                    $eventRaw['params'],
                );
                $eventModel = EventModelBuilder::createFromRequest($createEventRequest);
                $arrEventModel[] = $eventModel;
            }
        }
        return $arrEventModel;
    }
}
