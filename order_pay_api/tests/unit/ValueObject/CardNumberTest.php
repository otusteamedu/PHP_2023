<?php

declare(strict_types=1);

namespace unit\ValueObject;

use App\Exception\CardNumberException;
use App\ValueObject\CardNumber;
use PHPUnit\Framework\TestCase;

class CardNumberTest extends TestCase
{
    /**
     * @return void
     * @dataProvider providerValidCardNumber
     */
    public function testValidCardNumber(string $number): void
    {
        $cardExpiration = new CardNumber($number);
        $this->assertInstanceOf(CardNumber::class, $cardExpiration);
    }

    /**
     * @param string $number
     * @return void
     * @dataProvider providerInvalidCardNumber
     */
    public function testInvalidCardNumber(string $number): void
    {
        $this->expectException(CardNumberException::class);
        $this->expectExceptionMessageMatches('/card_number/');
        new CardNumber($number);
    }

    public static function providerValidCardNumber(): array
    {
        return [
            'dataset 1' => ['1234567891011121'], // 16 numbers
        ];
    }

    public static function providerInvalidCardNumber(): array
    {
        return [
            'dataset 1' => ['12345678910111213'], // 17 numbers
            'dataset 2' => ['123456789101112'], // 15 numbers
        ];
    }
}
