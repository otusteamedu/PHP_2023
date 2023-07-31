<?php

declare(strict_types=1);

namespace Imitronov\Hw15\Refactored\Domain\ValueObject;

use Imitronov\Hw15\Refactored\Domain\Exception\InvalidArgumentException;

final class Number
{
    private string $value;

    private int $scale;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string|int|float $value, int $scale = 10)
    {
        assert(
            is_numeric($value),
            new InvalidArgumentException('Некорректное число.'),
        );
        assert(
            $scale >= 0,
            new InvalidArgumentException('Точность не может быть меньше 0.'),
        );

        $this->value = (string) $value;
        $this->scale = $scale;
    }

    public static function zero(): self
    {
        return new self('0');
    }

    public static function hundred(): self
    {
        return new self('100');
    }

    public function getValue(?int $scale = null): string
    {
        return sprintf('%01.' . $this->scale . 'f', $scale ?? $this->value);
    }

    /**
     * Умножение двух чисел с произвольной точностью.
     * @throws InvalidArgumentException
     */
    public function mul(self $value): self
    {
        return new self(bcmul($this->getValue(), $value->getValue(), $this->scale));
    }

    /**
     * Деление чисел с произвольной точностью.
     * @throws InvalidArgumentException
     */
    public function div(self $value): self
    {
        if ($value->isEq(Number::zero())) {
            throw new InvalidArgumentException('Невозможно поделить на 0.');
        }

        return new self(bcdiv($this->getValue(), $value->getValue(), $this->scale));
    }

    /**
     * Сложение чисел с произвольной точностью.
     * @throws InvalidArgumentException
     */
    public function add(self $value): self
    {
        return new self(bcadd($this->getValue(), $value->getValue(), $this->scale));
    }

    /**
     * Вычитание чисел с заданной точностью.
     * @throws InvalidArgumentException
     */
    public function sub(self $value): self
    {
        return new self(bcsub($this->getValue(), $value->getValue(), $this->scale));
    }

    public function isEq(self $value): bool
    {
        return bccomp($this->getValue(), $value->getValue(), $this->scale) === 0;
    }
}
