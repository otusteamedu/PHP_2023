<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Exception\OrderSumException;

class OrderSum
{
    private string $sum;

    /**
     * @throws OrderSumException
     */
    public function __construct(string $sum)
    {
        $this->assertOrderSumIsValid($sum);
        $this->sum = $sum;
    }

    public function getSum(): string
    {
        return $this->sum;
    }

    /**
     * @throws OrderSumException
     */
    private function assertOrderSumIsValid(string $sum): void
    {
        if (1 != preg_match('/^[0-9]*,?[0-9]{2,}$/', $sum)) {
            throw new OrderSumException("'order_sum' is not valid");
        }
    }
}
