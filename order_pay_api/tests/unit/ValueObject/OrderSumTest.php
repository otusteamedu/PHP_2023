<?php

declare(strict_types=1);

namespace unit\ValueObject;

use App\Exception\OrderSumException;
use App\ValueObject\OrderSum;
use PHPUnit\Framework\TestCase;

class OrderSumTest extends TestCase
{
    /**
     * @return void
     * @dataProvider providerValidOrderSum
     */
    public function testValidOrderSum(string $sum): void
    {
        $cardExpiration = new OrderSum($sum);
        $this->assertInstanceOf(OrderSum::class, $cardExpiration);
    }

    /**
     * @param string $sum
     * @return void
     * @dataProvider providerInvalidOrderSum
     */
    public function testInvalidOrderSum(string $sum): void
    {
        $this->expectException(OrderSumException::class);
        $this->expectExceptionMessageMatches('/order_sum/');
        new OrderSum($sum);
    }

    public static function providerValidOrderSum(): array
    {
        return [
            'dataset 1' => ['12,34'],
            'dataset 2' => ['0,54'],
            'dataset 3' => ['5678'],
        ];
    }

    public static function providerInvalidOrderSum(): array
    {
        return [
            'dataset 1' => ['12,'],
            'dataset 2' => ['12,3'],
            'dataset 3' => ['abc'],
        ];
    }
}
