<?php

declare(strict_types=1);

namespace Gesparo\HW\Domain\List;

use Gesparo\HW\Domain\ValueObject\Condition;

class GetConditionList
{
    /**
     * @var Condition[]
     */
    private array $conditions;

    public function __construct(array $conditions)
    {
        $this->conditions = $conditions;
    }

    /**
     * @return Condition[]
     */
    public function getAll(): array
    {
        return $this->conditions;
    }
}
