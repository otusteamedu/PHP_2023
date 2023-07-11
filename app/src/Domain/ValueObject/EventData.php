<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Domain\ValueObject;

final class EventData
{
    public function __construct(
        private readonly string $type,
        private readonly string $name,
        private readonly \DateTimeInterface $dateTime,
    ) {
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDateTime(): \DateTimeInterface
    {
        return $this->dateTime;
    }
}
