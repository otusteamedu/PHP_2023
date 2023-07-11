<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Application\UseCase\Event;

use Imitronov\Hw12\Application\Dto\ConditionDto;

interface SearchEventsInput
{
    public function validate(): void;

    /**
     * @return ConditionDto[]
     */
    public function getConditions(): array;
}
