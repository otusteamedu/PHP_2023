<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Application\Factory;

use Imitronov\Hw12\Application\Dto\ConditionDto;
use Imitronov\Hw12\Domain\ValueObject\Condition;

final class ConditionFactory
{
    public function makeFromDto(ConditionDto $dto): Condition
    {
        return new Condition(
            $dto->key,
            $dto->value,
        );
    }
}
