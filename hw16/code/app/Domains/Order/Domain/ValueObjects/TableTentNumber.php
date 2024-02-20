<?php

namespace App\Domains\Order\Domain\ValueObjects;

use http\Exception\InvalidArgumentException;

class TableTentNumber
{
    private int $tableTentNumber;

    public function __construct(?int $tableTentNumber = null)
    {
        $this->assertValidTableTentNumber($tableTentNumber);
        $this->tableTentNumber = $tableTentNumber;
    }

    public function getValue(): int
    {
        return $this->tableTentNumber;
    }

    private function assertValidTableTentNumber(?int $tableTentNumber = null): void
    {
        if ($tableTentNumber === null) {
            return;
        }

        if ($tableTentNumber < 1 || $tableTentNumber > 99) {
            throw new InvalidArgumentException('Номер тейбл тента неверный');
        }
    }
}
