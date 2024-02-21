<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\InvalidArgumentException;

readonly class Condition
{
    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        private string $operandLeft,
        private string $operandRight,
    ) {
        $this->validate();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function validate(): void
    {
        if (
            empty($this->operandLeft)
            || empty($this->operandRight)
        ) {
            throw new InvalidArgumentException('Условие должно содержать имя параметра и его значение');
        }
    }

    public function getOperandLeft(): string
    {
        return $this->operandLeft;
    }

    public function getOperandRight(): string
    {
        return $this->operandRight;
    }
}
