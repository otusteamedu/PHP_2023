<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure\Storage\Mongo;

use Gesparo\HW\Domain\Entity\Event;
use Gesparo\HW\Domain\List\GetConditionList;
use Gesparo\HW\Domain\ValueObject\Condition;
use Gesparo\HW\Domain\ValueObject\Name;
use Gesparo\HW\Domain\ValueObject\Priority;
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

        foreach ($list->getAll() as $condition) {
            $result["conditions.{$condition->getName()}"] = $condition->getValue();
        }

        return $result;
    }

    private function convertToEvent(BSONDocument $result): Event
    {
        $conditions = [];

        foreach ($result['conditions']->getArrayCopy() as $param => $value) {
            $conditions[] = new Condition($param, $value);
        }

        return new Event(new Name($result['event']), new Priority($result['priority']), $conditions);
    }
}
