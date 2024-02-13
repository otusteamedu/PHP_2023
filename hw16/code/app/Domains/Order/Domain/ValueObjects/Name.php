<?php

namespace App\Domains\Order\Domain\ValueObjects;

class Name
{
    private string $name;
    public function __construct(string $name)
    {
        $this->assertValidName($name);
        $this->name = $name;
    }

    public function getValue(): string
    {
        return $this->name;
    }

    private function assertValidName(string $name): void
    {
        $strlen = mb_strlen($name);
        if ($strlen < 2 || $strlen > 100) {
            throw new \InvalidArgumentException('Имя продукта не валидно');
        }
    }

}
