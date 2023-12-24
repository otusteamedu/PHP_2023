<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Exception\CardExpirationException;

class CardExpiration
{
    private string $expiration;

    /**
     * @throws CardExpirationException
     */
    public function __construct(string $expiration)
    {
        $this->assertCardExpirationIsValid($expiration);
        $this->expiration = $expiration;
    }

    public function getExpiration(): string
    {
        return $this->expiration;
    }

    /**
     * @throws CardExpirationException
     */
    private function assertCardExpirationIsValid(string $expiration): void
    {
        if (1 != preg_match('/^[0-9]{2}\/[0-9]{2}$/', $expiration)) {
            throw new CardExpirationException("'card_expiration' is not valid");
        }
    }
}
