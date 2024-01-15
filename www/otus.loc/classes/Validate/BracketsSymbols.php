<?php

namespace Sherweb\Validate;

/**
 * Class BracketsSymbols
 */
class BracketsSymbols
{
    /**
     * @param string|null $string $string
     * @return bool
     */
    public static function isValid(?string $string): bool
    {
        if (!$string) {
            return false;
        }

        $length = strlen($string);

        // 0. Check string length
        if ($length % 2 != 0) {
            return false;
        }

        // 1. Check first and last characters
        if ($string[0] !== '(' || $string[$length - 1] !== ')') {
            return false;
        }

        // 2. Check balanced parentheses
        $counter = 0;
        for ($i = 0; $i < $length; $i++) {
            if ($string[$i] === '(') {
                $counter++;
            } elseif ($string[$i] === ')') {
                $counter--;
            }
            if ($counter < 0) {
                return false;
            }
        }

        return $counter === 0;
    }
}