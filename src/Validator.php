<?php

declare(strict_types=1);

namespace Twent\BracketsValidator;

use SplStack;
use Twent\BracketsValidator\Enums\ClosingBrackets;
use Twent\BracketsValidator\Enums\Brackets;
use Twent\BracketsValidator\Exceptions\EmptyStringException;
use Twent\BracketsValidator\Exceptions\InvalidArgumentException;

final class Validator
{
    /**
     * @throws InvalidArgumentException
     * @throws EmptyStringException
     */
    public static function run(string $string): bool
    {
        $string = trim($string, "\x00..\x24\x5F");

        if (empty($string)) {
            throw new EmptyStringException();
        }

        if (strlen($string) === 1) {
            throw new InvalidArgumentException();
        }

        $brackets = Brackets::match();
        $stack = new SplStack();

        foreach (str_split($string) as $char) {
            if (in_array($char, array_keys($brackets))) {
                $stack->push($char);
                continue;
            }

            if ($stack->count() === 0) {
                throw new InvalidArgumentException();
            }

            if (!in_array($char, array_values($brackets))) {
                continue;
            }

            $lastItemFromStack = $stack->pop();
            if ($brackets[$lastItemFromStack] !== $char) {
                throw new InvalidArgumentException();
            }
        }

        if ($stack->count() !== 0) {
            throw new InvalidArgumentException();
        }

        return true;
    }
}
