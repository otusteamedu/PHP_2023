<?php

declare(strict_types=1);

namespace unit\ValueObject;

use App\Exception\CardExpirationException;
use App\ValueObject\CardExpiration;
use PHPUnit\Framework\TestCase;

class CardExpirationTest extends TestCase
{
    /**
     * @dataProvider providerValidCardExpiration
     */
    public function testValidCardExpiration(string $expiration): void
    {
        $cardExpiration = new CardExpiration($expiration);
        $this->assertInstanceOf(CardExpiration::class, $cardExpiration);
    }

    /**
     * @dataProvider providerInvalidCardExpiration
     */
    public function testInvalidCardExpiration(string $expiration): void
    {
        $this->expectException(CardExpirationException::class);
        $this->expectExceptionMessageMatches('/card_expiration/');
        new CardExpiration($expiration);
    }

    public static function providerValidCardExpiration(): array
    {
        return [
            'dataset 1' => ['09/24'],
        ];
    }

    public static function providerInvalidCardExpiration(): array
    {
        return [
            'dataset 1' => ['0924'],
            'dataset 2' => ['1/32'],
            'dataset 3' => ['12/2'],
        ];
    }
}
