<?php

declare(strict_types=1);

namespace unit\ValueObject;

use App\Exception\CvvException;
use App\ValueObject\Cvv;
use PHPUnit\Framework\TestCase;

class CvvTest extends TestCase
{
    /**
     * @return void
     * @dataProvider providerValidCvv
     */
    public function testValidCvv(string $cvv): void
    {
        $cardExpiration = new Cvv($cvv);
        $this->assertInstanceOf(Cvv::class, $cardExpiration);
    }

    /**
     * @param string $cvv
     * @return void
     * @dataProvider providerInvalidCvv
     */
    public function testInvalidCvv(string $cvv): void
    {
        $this->expectException(CvvException::class);
        $this->expectExceptionMessageMatches('/cvv/');
        new Cvv($cvv);
    }

    public static function providerValidCvv(): array
    {
        return [
            'dataset 1' => ['123'],
        ];
    }

    public static function providerInvalidCvv(): array
    {
        return [
            'dataset 1' => ['1234'],
            'dataset 2' => ['12'],
        ];
    }
}
