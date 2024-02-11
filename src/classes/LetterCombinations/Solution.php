<?php

namespace Klobkovsky\App\LetterCombinations;

class Solution
{

    /**
     * @param String $digits
     * @return String[]
     */

    protected const KEY_MAP = [
        2 => ['a', 'b', 'c'],
        3 => ['d', 'e', 'f'],
        4 => ['g', 'h', 'i'],
        5 => ['j', 'k', 'l'],
        6 => ['m', 'n', 'o'],
        7 => ['p', 'q', 'r', 's'],
        8 => ['t', 'u', 'v'],
        9 => ['w', 'x', 'y', 'z'],
    ];

    public static function letterCombinations(string $digits): array
    {
        if (strlen($digits) > 4) {
            throw new \Exception("Длина строки не должна быть больше 4");
        }

        return self::getCombinationsRecursive(str_split($digits));
    }

    protected static function getCombinationsRecursive(array $digits, array $combinations = []): array
    {
        if (count($digits) === 0) {
            return $combinations;
        }

        $currentDigit = (int)array_shift($digits);

        if (!isset(self::KEY_MAP[$currentDigit])) {
            throw new \Exception('Некорректная цифра');
        }

        if (empty($combinations)) {
            return self::getCombinationsRecursive($digits, self::KEY_MAP[$currentDigit]);
        }

        $result = [];

        foreach ($combinations as $combination) {
            foreach (self::KEY_MAP[$currentDigit] as $letter) {
                $result[] = $combination . $letter;
            }
        }

        return self::getCombinationsRecursive($digits, $result);
    }
}
