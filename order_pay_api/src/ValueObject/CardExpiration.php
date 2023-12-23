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

    /**
     * @return string
     */
    public function getExpiration(): string
    {
        return $this->expiration;
    }

    /**
     * @throws CardExpirationException
     */
    private function assertCardExpirationIsValid(string $expiration): void
    {
        if (preg_match('/^[0-9]{2}\/[0-9]{2}$/', $expiration) != 1) {
            throw new CardExpirationException("'card_expiration' is not valid");
        }
    }
}
