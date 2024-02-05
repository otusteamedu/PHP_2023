<?php

declare(strict_types=1);

namespace Yalanskiy\LeetCode\LetterCombinations;

use InvalidArgumentException;

/**
 * Class Solution
 */
class Solution
{
    private const MAP = [
        2 => 'abc',
        3 => 'def',
        4 => 'ghi',
        5 => 'jkl',
        6 => 'mno',
        7 => 'pqrs',
        8 => 'tuv',
        9 => 'wxyz',
    ];

    /**
     * @param String $digits
     *
     * @return String[]
     */
    public static function letterCombinations(string $digits): array
    {
        if (strlen($digits) > 4) {
            throw new InvalidArgumentException("Incorrect number of digits.");
        }

        if (strlen($digits) === 0) {
            return [];
        }

        return self::getCombinationsByIndex($digits, 0);
    }

    private static function getCombinationsByIndex(string $digits, int $index): array
    {
        if ($index >= strlen($digits)) {
            return [''];
        }

        $digit = (int)$digits[$index];
        if (!isset(self::MAP[$digit])) {
            throw new InvalidArgumentException("Incorrect digit.");
        }

        $chars = self::MAP[$digit];
        $out = [];
        for ($i = 0; $i < strlen($chars); $i++) {
            $char = $chars[$i];

            $nextChars = self::getCombinationsByIndex($digits, $index + 1);
            foreach ($nextChars as $nextChar) {
                $out[] = $char . $nextChar;
            }
        }

        return $out;
    }
}
