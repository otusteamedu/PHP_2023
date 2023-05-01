<?php

declare(strict_types=1);

namespace Twent\BracketsValidator\Domain;

use SplStack;
use Twent\BracketsValidator\Application\Exceptions\InvalidArgument;
use Twent\BracketsValidator\Domain\Contract\ValidatorContract;
use Twent\BracketsValidator\Domain\Enum\Brackets;
use Twent\BracketsValidator\Domain\ValueObject\InputString;

final class Validator implements ValidatorContract
{
    /**
     * @throws InvalidArgument
     */
    public function run(InputString $string): bool
    {
        $chars = str_split($string->getValue());
        $stack = new SplStack();

        foreach ($chars as $char) {
            if (self::isOpeningBracket($char)) {
                $stack->push($char);
                continue;
            }

            if ($stack->isEmpty()) {
                throw new InvalidArgument();
            }

            if (! self::isClosingBracket($char)) {
                continue;
            }

            $lastBracketFromStack = $stack->pop();

            if (
                ! self::isRequiredClosingBracket($lastBracketFromStack, $char)
            ) {
                throw new InvalidArgument();
            }
        }

        if (! $stack->isEmpty()) {
            throw new InvalidArgument();
        }

        return true;
    }

    private function isOpeningBracket(string $char): bool
    {
        return in_array($char, array_keys(Brackets::match()));
    }

    private function isClosingBracket(string $char): bool
    {
        return in_array($char, array_values(Brackets::match()));
    }

    private function isRequiredClosingBracket(
        string $openingBracket,
        string $char
    ): bool {
        return Brackets::match()[$openingBracket] === $char;
    }
}
