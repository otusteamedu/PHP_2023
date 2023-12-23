<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Exception\CardHolderException;

class CardHolder
{
    private string $holder;

    /**
     * @throws CardHolderException
     */
    public function __construct(string $holder)
    {
        $this->assertCardHolderIsValid($holder);
        $this->holder = $holder;
    }

    /**
     * @return string
     */
    public function getHolder(): string
    {
        return $this->holder;
    }

    /**
     * @throws CardHolderException
     */
    private function assertCardHolderIsValid(string $holder): void
    {
        if (preg_match('/^[A-Z\s{2,}-]+$/', $holder) != 1) {
            throw new CardHolderException("'card_holder' is not valid");
        }
    }
}
