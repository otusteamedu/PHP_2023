<?php

declare(strict_types=1);

namespace App\Modules\Orders\Domain\ValueObject;

class Email
{
    private string $value;
    public function __construct(string $value)
    {
        $this->assertValidValue($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidValue(string $value) : void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Поле email некорректно');
        }
    }
}
