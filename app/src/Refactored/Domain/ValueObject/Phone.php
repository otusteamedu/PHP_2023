<?php

declare(strict_types=1);

namespace Imitronov\Hw15\Refactored\Domain\ValueObject;

use Imitronov\Hw15\Refactored\Domain\Exception\InvalidArgumentException;

final class Phone
{
    private readonly string $value;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        assert(
            strlen(sprintf('%s', $value)) > 0,
            new InvalidArgumentException('Телефон не может быть пустым.'),
        );

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
