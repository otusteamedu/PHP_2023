<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\Error;

final class Id
{
    private string $value;

    public function __construct(string|int $value)
    {
        assert(
            strlen(sprintf('%s', $value)) > 0,
            new Error('ID не может быть пустым.'),
        );

        $this->value = (string) $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEq(self $id): bool
    {
        return 0 === strcasecmp($this->value, $id->getValue());
    }
}
