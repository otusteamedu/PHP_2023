<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Exception\OrderNumberException;

class OrderNumber
{
    private string $number;

    /**
     * @throws OrderNumberException
     */
    public function __construct(string $number)
    {
        $this->assertOrderNumberIsValid($number);
        $this->number = $number;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @throws OrderNumberException
     */
    private function assertOrderNumberIsValid(string $number): void
    {
        if (1 != preg_match('/^[0-9]{1,16}$/', $number)) {
            throw new OrderNumberException("'order_number' is not valid");
        }
    }
}
