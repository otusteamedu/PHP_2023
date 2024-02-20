<?php

namespace App\Domains\Order\Domain\ValueObjects;

use http\Exception\InvalidArgumentException;

class EmployeeID
{
    private int $employeeId;

    public function __construct(int $employeeId)
    {
        $this->assertValidShopId($employeeId);
        $this->employeeId = $employeeId;
    }

    public function getValue(): int
    {
        return $this->employeeId;
    }

    private function assertValidShopId(int $employeeId): void
    {
        if (!in_array($employeeId, [1, 2, 3])) {
            throw new InvalidArgumentException('Id сорудника не валидно');
        }
    }

}
