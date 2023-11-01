<?php

declare(strict_types=1);

namespace Gesparo\HW\Storage\Redis;

trait ConditionNameTrait
{
    protected function getConditionName(array $eventConditions): string
    {
        ksort($eventConditions);

        $conditions = [];

        foreach ($eventConditions as $key => $value) {
            $conditions[] = "$key:$value";
        }

        $conditions = implode('_', $conditions);

        return "conditions:$conditions";
    }
}
