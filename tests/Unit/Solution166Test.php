<?php

namespace tests\Unit;

use Codeception\Attribute\DataProvider;
use Codeception\PHPUnit\TestCase;
use src\problem166\Solution;
use Tests\Support\UnitTester;

class Solution166Test extends TestCase
{
    protected UnitTester $tester;

    /**
     * @return array
     */
    private function dataProvider(): array
    {
        return [
            [2,   1, '2'],
            [4, 333, '0.(012)'],
            [1,   6, '0.1(6)'],

            [1,   2, '0.5'],
            [2,   3, '0.(6)'],
            [1,   3, '0.(3)'],
            [1,   8, '0.125'],
            [7,   9, '0.(7)'],
            [1,   7, '0.(142857)'],
            [9,  10, '0.9'],

            [5,     6, '0.8(3)'],
            [23,   99, '0.(23)'],
            [123, 999, '0.(123)'],
            [7,    12, '0.58(3)'],
            [7,    11, '0.(63)'],
            [17,   11, '1.(54)'],
            [25,   39, '0.(641025)'],
            [9200,  3, '3066.(6)'],

            [26,   15, '1.7(3)'],

            [7,   -12, '-0.58(3)'],
            [-1, -2147483648, '0.0000000004656612873077392578125'],
        ];
    }

    #[DataProvider('dataProvider')]
    public function testExampleWithData($numerator, $denominator, $expect): void
    {
        $result = (new Solution())->fractionToDecimal($numerator, $denominator);

        $this->assertSame($expect, $result);
    }
}
