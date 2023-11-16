<?php

declare(strict_types=1);

namespace Gesparo\HW\Storage\Mongo;

use Gesparo\HW\Event\Event;
use Gesparo\HW\Event\GetConditionList;
use MongoDB\Collection;
use MongoDB\Model\BSONDocument;

class EventGetter
{
    private Collection $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function get(GetConditionList $list): ?Event
    {
        /** @var BSONDocument|null $result */
        $result = $this->collection->findOne($this->getFilter($list), ['sort' => ['priority' => -1]]);

        if ($result === null) {
            return null;
        }

        $event = $this->convertToEvent($result);

        $this->collection->deleteOne(['_id' => $result['_id']]);

        return $event;
    }

    private function getFilter(GetConditionList $list): array
    {
        $result = [];

        foreach ($list->getAll() as $param => $value) {
            $result["conditions.$param"] = $value;
        }

        return $result;
    }

    private function convertToEvent(BSONDocument $result): Event
    {
        return new Event([
            'priority' => $result['priority'],
            'conditions' => $result['conditions']->getArrayCopy(),
            'event' => $result['event'],
        ]);
    }
}
