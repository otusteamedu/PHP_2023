<?php

declare(strict_types=1);

namespace src;

use InvalidArgumentException;

/**
 * Validate string with brackets.
 */
class StringValidator
{
    /**
     * Validate string with brackets.
     *
     * @param string $string
     *
     * @return void
     */
    public static function validate(string $string): void
    {
        $string = trim($string);

        if (empty($string)) {
            throw new InvalidArgumentException("String is emoty");
        }

        $brackets = 0;
        for ($idx = 0; $idx < mb_strlen($string); $idx++) {
            $char = $string[$idx];
            if ($char == '(') {
                $brackets++;
            }

            if ($char == ')') {
                $brackets--;
            }

            if ($brackets < 0) {
                throw new InvalidArgumentException("Too mach close brackets");
            }
        }

        if ($brackets) {
            throw new InvalidArgumentException("Too mach open brackets");
        }
    }
}
