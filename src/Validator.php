<?php

declare(strict_types=1);

namespace Twent\BracketsValidator;

use SplStack;
use Twent\BracketsValidator\Enums\Brackets;
use Twent\BracketsValidator\Exceptions\EmptyString;
use Twent\BracketsValidator\Exceptions\InvalidArgument;

final class Validator
{
    /**
     * @throws InvalidArgument
     * @throws EmptyString
     */
    public static function run(?string $string): bool
    {
        if (! $string) {
            throw new EmptyString();
        }

        $string = self::validateString($string);

        $bracketsStack = self::matchBrackets($string);

        if ($bracketsStack->count() !== 0) {
            throw new InvalidArgument();
        }

        return true;
    }

    /**
     * @throws EmptyString
     * @throws InvalidArgument
     */
    private static function validateString(?string $string): ?string
    {
        $string = trim($string, "\x00..\x24\x5F");

        if (! $string) {
            throw new EmptyString();
        }

        if (strlen($string) === 1) {
            throw new InvalidArgument();
        }

        return $string;
    }

    private static function matchBrackets(string $string): SplStack
    {
        $stack = new SplStack();

        foreach (str_split($string) as $char) {
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

            $lastItemFromStack = $stack->pop();

            if (! self::isBracketsMatch($lastItemFromStack, $char)) {
                throw new InvalidArgument();
            }
        }

        return $stack;
    }

    private static function isOpeningBracket(string $char): bool
    {
        return in_array($char, array_keys(Brackets::match()));
    }

    private static function isClosingBracket(string $char): bool
    {
        return in_array($char, array_values(Brackets::match()));
    }

    private static function isBracketsMatch(
        string $openingBracket,
        string $char
    ): bool {
        return Brackets::match()[$openingBracket] === $char;
    }
}
