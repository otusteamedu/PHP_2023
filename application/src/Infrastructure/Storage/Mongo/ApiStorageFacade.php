<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure\Storage\Mongo;

use Gesparo\HW\Domain\Entity\Event;
use Gesparo\HW\Domain\List\EventList;
use Gesparo\HW\Domain\List\GetConditionList;
use Gesparo\HW\Infrastructure\Storage\BaseStorageFacade;
use MongoDB\Collection;
use MongoDB\Database;

class ApiStorageFacade extends BaseStorageFacade
{
    private Collection $collection;

    public function __construct(Database $database)
    {
        $this->collection = $database->selectCollection('events');
    }

    public function add(EventList $list): void
    {
        $eventSetter = new EventSetter($this->collection);

        foreach ($list as $event) {
            $eventSetter->set($event);
        }
    }

    public function clear(): void
    {
        $this->collection->deleteMany([]);
    }

    public function get(GetConditionList $list): ?Event
    {
        return (new EventGetter($this->collection))->get($list);
    }
}
