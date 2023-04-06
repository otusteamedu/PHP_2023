<?php

declare(strict_types=1);

namespace Twent\Hw14;

class Solution
{
    const BUTTONS = [
        2 => ['a', 'b', 'c'],
        3 => ['d', 'e', 'f'],
        4 => ['g', 'h', 'i'],
        5 => ['j', 'k', 'l'],
        6 => ['m', 'n', 'o'],
        7 => ['p', 'q', 'r', 's'],
        8 => ['t', 'u', 'v'],
        9 => ['w', 'x', 'y', 'z']
    ];

    public function letterCombinations(string $digits): array
    {
        if (empty($digits)) {
            return [];
        }

        $digits = str_split($digits);

        $result = self::BUTTONS[array_shift($digits)];

        if (count($digits) === 0) {
            return $result;
        }

        foreach ($digits as $digit) {
            $temp = [];

            foreach ($result as $letter1) {
                foreach (self::BUTTONS[$digit] as $letter2) {
                    $temp[] = "{$letter1}{$letter2}";
                }
            }

            $result = $temp;
        }

        return $result;
    }
}
