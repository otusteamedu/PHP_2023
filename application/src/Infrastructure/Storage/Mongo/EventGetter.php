<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure\Storage\Mongo;

use Gesparo\HW\Application\ConditionFactory;
use Gesparo\HW\Application\EventFactory;
use Gesparo\HW\Domain\Entity\Event;
use Gesparo\HW\Domain\List\GetConditionList;
use MongoDB\Collection;
use MongoDB\Model\BSONDocument;

class EventGetter
{
    private Collection $collection;
    private EventFactory $eventFactory;
    private ConditionFactory $conditionFactory;

    public function __construct(Collection $collection, EventFactory $eventFactory, ConditionFactory $conditionFactory)
    {
        $this->collection = $collection;
        $this->eventFactory = $eventFactory;
        $this->conditionFactory = $conditionFactory;
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

        foreach ($list->getAll() as $condition) {
            $result["conditions.{$condition->getName()}"] = $condition->getValue();
        }

        return $result;
    }

    private function convertToEvent(BSONDocument $result): Event
    {
        $conditions = [];

        foreach ($result['conditions']->getArrayCopy() as $param => $value) {
            $conditions[] = $this->conditionFactory->create($param, $value);
        }

        return $this->eventFactory->create($result['event'], $result['priority'], $conditions);
    }
}
