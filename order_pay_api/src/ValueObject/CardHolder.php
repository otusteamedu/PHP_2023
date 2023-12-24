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

    public function getHolder(): string
    {
        return $this->holder;
    }

    /**
     * @throws CardHolderException
     */
    private function assertCardHolderIsValid(string $holder): void
    {
        if (1 != preg_match('/^[A-Z\s{2,}-]+$/', $holder)) {
            throw new CardHolderException("'card_holder' is not valid");
        }
    }
}
