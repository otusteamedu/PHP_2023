<?php

declare(strict_types=1);

namespace Twent\BracketsValidator;

use SplStack;
use Twent\BracketsValidator\Enums\ClosingBrackets;
use Twent\BracketsValidator\Enums\OpeningBrackets;
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
        $string = htmlspecialchars(trim($string, "\x00..\x24\x5F"));

        if (empty($string)) {
            throw new EmptyStringException();
        }

        if (strlen($string) === 1) {
            throw new InvalidArgumentException();
        }

        $bracketsMatch = array_combine(OpeningBrackets::values(), ClosingBrackets::values());
        $stack = new SplStack();

        foreach (str_split($string) as $char) {
            if (in_array($char, OpeningBrackets::values())) {
                $stack->push($char);
                continue;
            }

            if ($stack->count() === 0) {
                throw new InvalidArgumentException();
            }

            if (!in_array($char, ClosingBrackets::values())) {
                continue;
            }

            $lastItemFromStack = $stack->pop();
            if ($bracketsMatch[$lastItemFromStack] !== $char) {
                throw new InvalidArgumentException();
            }
        }

        if ($stack->count() !== 0) {
            throw new InvalidArgumentException();
        }

        return true;
    }
}
