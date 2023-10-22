<?php

declare(strict_types=1);

namespace App\LetterCombinations;

final class Solution
{
    public const LETTERS = [
        2 => ['a', 'b', 'c'],
        3 => ['d', 'e', 'f'],
        4 => ['g', 'h', 'i'],
        5 => ['j', 'k', 'l'],
        6 => ['m', 'n', 'o'],
        7 => ['p', 'q', 'r', 's'],
        8 => ['t', 'u', 'v'],
        9 => ['w', 'x', 'y', 'z']
    ];

    public static function letterCombinations(string $digits): array
    {
        if (!$length = strlen($digits)) {
            return [];
        }

        $result = [];
        for ($i = 0; $i < $length; $i++) {
            $letters = self::LETTERS[(int)$digits[$i]] ?? [];

            if (empty($result)) {
                $result = $letters;
                continue;
            }

            $temp = [];
            foreach ($result as $item) {
                foreach ($letters as $letter) {
                    $temp[] = $item . $letter;
                }
            }
            $result = $temp;
        }

        return $result;
    }
}
