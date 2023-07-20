<?php

declare(strict_types=1);

namespace Imitronov\Hw14\LetterCombination;

/**
 * @link https://leetcode.com/problems/letter-combinations-of-a-phone-number/
 */
class Solution
{
    public array $letters = [
        2 => ['a', 'b', 'c'],
        3 => ['d', 'e', 'f'],
        4 => ['g', 'h', 'i'],
        5 => ['j', 'k', 'l'],
        6 => ['m', 'n', 'o'],
        7 => ['p', 'q', 'r', 's'],
        8 => ['t', 'u', 'v'],
        9 => ['w', 'x', 'y', 'z'],
    ];

    /**
     * @return string[]
     */
    public function letterCombinations(string $digits): array
    {
        $len = strlen($digits);
        $result = [];

        if ($len === 0) {
            return $result;
        }

        $result = $this->letters[$digits[0]];

        for ($i = 1; $i < $len; $i++) {
            $newResult = [];

            foreach ($result as $prefix) {
                foreach ($this->letters[$digits[$i]] as $letter) {
                    $newResult[] = $prefix . $letter;
                }
            }

            $result = $newResult;
        }

        return $result;
    }
}
