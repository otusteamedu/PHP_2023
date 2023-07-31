<?php

declare(strict_types=1);

namespace Imitronov\Hw15\Refactored\Domain\ValueObject;

use Imitronov\Hw15\Refactored\Domain\Exception\InvalidArgumentException;

final class Id
{
    private readonly string $value;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string|int $value)
    {
        assert(
            strlen(sprintf('%s', $value)) > 0,
            new InvalidArgumentException('ID не может быть пустым.'),
        );

        $this->value = (string) $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
