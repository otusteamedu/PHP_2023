<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\InvalidArgumentException;

readonly class Occasion
{
    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        private string $name,
        private string $value,
    ) {
        $this->validate();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function validate(): void
    {
        if (
            empty($this->name)
            || empty($this->value)
        ) {
            throw new InvalidArgumentException('Событие должно содержать имя параметра и его значение');
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
