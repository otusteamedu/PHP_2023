<?php

declare(strict_types=1);

namespace Tests\Unit;

use Exception;
use Tests\TestCase;
use Twent\BracketsValidator\Application\Exceptions\EmptyString;
use Twent\BracketsValidator\Domain\Validator;
use Twent\BracketsValidator\Domain\ValueObject\InputString;

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
                fn() => (new Validator())->run(new InputString($wrongInput)),
                Exception::class
            );
        }
    }

    /**
     * @throws EmptyString
     */
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
            $this->assertTrue((new Validator())->run(new InputString($rightInput)));
        }
    }
}
