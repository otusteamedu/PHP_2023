<?php

declare(strict_types=1);

namespace App\Modules\Orders\Domain\ValueObject;

class UUID
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
        if (!preg_match('/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}$/', $value)) {
            throw new \InvalidArgumentException('Поле "UUID" невалидно');
        }
    }
}
