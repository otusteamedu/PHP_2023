<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Exception\CardNumberException;

class CardNumber
{
    private string $number;

    /**
     * @throws CardNumberException
     */
    public function __construct(string $number)
    {
        $this->assertCardNumberIsValid($number);
        $this->number = $number;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @throws CardNumberException
     */
    private function assertCardNumberIsValid(string $number): void
    {
        if (1 != preg_match('/^[0-9]{16}$/', $number)) {
            throw new CardNumberException("'card_number' is not valid");
        }
    }
}
