<?php

namespace App\Tests\Unit\Service;

use App\Exception\EmptyStringException;
use App\Service\StringBracketsVerifier;
use PHPUnit\Framework\TestCase;

class VerifyStringControllerTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     * @throws EmptyStringException
     */
    public function testVerifyStingBrackets(string $s, bool $result): void
    {
        $verifier = new StringBracketsVerifier();

        $this->assertEquals($result, $verifier->verify($s));
    }

    public function dataProvider(): array
    {
        return [
            ['(', false],
            ['()', true],
            ['(()(()())())', true],
            [')(', false],
            ['()(()', false],
            ['(()(()))((())()())', true],
            ['(()()()()))((((()()()))(()()()(((()))))))', false],
        ];
    }
}
