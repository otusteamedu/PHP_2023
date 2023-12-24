<?php

declare(strict_types=1);

namespace unit\ValueObject;

use App\Exception\CardHolderException;
use App\ValueObject\CardHolder;
use PHPUnit\Framework\TestCase;

class CardHolderTest extends TestCase
{
    /**
     * @dataProvider providerValidCardHolder
     */
    public function testValidCardHolder(string $holder): void
    {
        $cardExpiration = new CardHolder($holder);
        $this->assertInstanceOf(CardHolder::class, $cardExpiration);
    }

    /**
     * @dataProvider providerInvalidCardHolder
     */
    public function testInvalidCardHolder(string $holder): void
    {
        $this->expectException(CardHolderException::class);
        $this->expectExceptionMessageMatches('/card_holder/');
        new CardHolder($holder);
    }

    public static function providerValidCardHolder(): array
    {
        return [
            'dataset 1' => ['IVANOV IVAN'],
            'dataset 2' => ['IVANOV-VANOV IVAN'],
        ];
    }

    public static function providerInvalidCardHolder(): array
    {
        return [
            'dataset 1' => ['ИВАНОВ ИВАН'],
            'dataset 2' => ['ivanov ivan'],
        ];
    }
}
