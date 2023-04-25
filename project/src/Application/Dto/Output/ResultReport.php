<?php

declare(strict_types=1);

namespace Vp\App\Application\Dto\Output;

use Illuminate\Support\Collection;

class ResultReport
{
    private Collection $result;
    private string $aggregateField;
    private string $joinedField;

    public function __construct(Collection $result, string $aggregateField, string $joinedField)
    {
        $this->result = $result;
        $this->aggregateField = $aggregateField;
        $this->joinedField = $joinedField;
    }

    public function getResult(): Collection
    {
        return $this->result;
    }

    public function getAggregateField(): string
    {
        return $this->aggregateField;
    }

    public function getJoinedField(): string
    {
        return $this->joinedField;
    }
}
