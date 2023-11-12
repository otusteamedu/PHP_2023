<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure\Storage\Redis;

use Gesparo\HW\Domain\ValueObject\Condition;

trait ConditionNameTrait
{
    /**
     * @param Condition[] $eventConditions
     * @return string
     */
    protected function getConditionName(array $eventConditions): string
    {
        ksort($eventConditions);

        $conditions = [];

        foreach ($eventConditions as $condition) {
            $conditions[] = "{$condition->getName()}:{$condition->getValue()}";
        }

        $conditions = implode('_', $conditions);

        return "conditions:$conditions";
    }
}
