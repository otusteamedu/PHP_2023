<?php

declare(strict_types=1);

namespace Otus\App\EventSourcing\Infrastructure;

use Otus\App\EventSourcing\Domain\Model\Condition;
use Otus\App\Hydrator\Domain\Contract\HydratorInterface;

class ConditionHydrator implements HydratorInterface
{
    /**
     * @param Condition[] $array
     */
    public function hydrate(array $array): string
    {
        if (empty($array)) {
            throw new \LogicException('You must have at least one condition');
        }

        $params = [];

        foreach ($array as $condition) {
            $params[] = "{$condition->getKey()}:{$condition->getValue()}";
        }

        return implode(':', $params);
    }
}
