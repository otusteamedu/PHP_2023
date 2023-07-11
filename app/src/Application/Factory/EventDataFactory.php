<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Application\Factory;

use Imitronov\Hw12\Application\Dto\EventDataDto;
use Imitronov\Hw12\Domain\ValueObject\EventData;

final class EventDataFactory
{
    public function makeFromDto(EventDataDto $dto): EventData
    {
        return new EventData(
            $dto->type,
            $dto->name,
            $dto->dateTime,
        );
    }
}
