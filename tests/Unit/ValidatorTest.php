<?php

declare(strict_types=1);

namespace Tests\Unit;

use Exception;
use Tests\TestCase;
use Twent\BracketsValidator\Exceptions\EmptyString;
use Twent\BracketsValidator\Validator;

final class ValidatorTest extends TestCase
{
    public function testValidatorInstanceIsValid(): void
    {
        $validator = new Validator();
        $this->assertInstanceOf(Validator::class, $validator);
        $this->assertTrue(method_exists($validator, 'run'));
    }

    public function testValidatorFailsWithWrongData(): void
    {
        $wrongInputs = [
            '__',
            '      ',
            '2353464',
            '****',
            '__(',
            '   (){',
            '(()()()()))((((()()()))(()()()(((()))))))',
            ')(',
            '(()',
        ];

        foreach ($wrongInputs as $wrongInput) {
            $this->assertThrowsException(
                fn() => Validator::run($wrongInput),
                Exception::class
            );
        }
    }

    public function testValidatorWorksWithRightData(): void
    {
        $rightInputs = [
            '__()',
            '      ((()()()()))((((()()()))(()()()(((()))))))',
            '{{((__[[() () [345]]]))345}}(({}456))',
            '()',
            '(({}))[[{}{{{(([]))}}}]]',
        ];

        foreach ($rightInputs as $rightInput) {
            $this->assertTrue(Validator::run($rightInput));
        }
    }
}
