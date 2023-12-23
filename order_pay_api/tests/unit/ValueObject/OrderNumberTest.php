<?php

declare(strict_types=1);

namespace unit\ValueObject;

use App\Exception\OrderNumberException;
use App\ValueObject\OrderNumber;
use PHPUnit\Framework\TestCase;

class OrderNumberTest extends TestCase
{
    /**
     * @return void
     * @dataProvider providerValidOrderNumber
     */
    public function testValidOrderNumber(string $orderNumber): void
    {
        $cardExpiration = new OrderNumber($orderNumber);
        $this->assertInstanceOf(OrderNumber::class, $cardExpiration);
    }

    /**
     * @param string $orderNumber
     * @return void
     * @dataProvider providerInvalidOrderNumber
     */
    public function testInvalidOrderNumber(string $orderNumber): void
    {
        $this->expectException(OrderNumberException::class);
        $this->expectExceptionMessageMatches('/order_number/');
        new OrderNumber($orderNumber);
    }

    public static function providerValidOrderNumber(): array
    {
        return [
            'dataset 1' => ['1'],
            'dataset 2' => ['1234567891011121'], // 16 numbers
        ];
    }

    public static function providerInvalidOrderNumber(): array
    {
        return [
            'dataset 1' => [''],
            'dataset 2' => ['12345678910111213'], // 17 numbers
        ];
    }
}
