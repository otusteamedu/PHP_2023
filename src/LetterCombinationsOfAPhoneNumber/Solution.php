<?php

declare(strict_types=1);

namespace App\LetterCombinationsOfAPhoneNumber;

class Solution
{
    /**
     * @param String $digits
     * @return String[]
     */
    public function letterCombinations($digits)
    {
        $mapping = [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z']
        ];

        if (empty($digits)) {
            return [];
        }

        return $this->generateCombinations($digits, $mapping, '', []);
    }

    public function generateCombinations($digits, $mapping, $current, $combinations)
    {
        if (empty($digits)) {
            $combinations[] = $current;
            return $combinations;
        }

        $digit = $digits[0];
        $letters = $mapping[$digit];

        foreach ($letters as $letter) {
            $combinations = $this->generateCombinations(
                substr($digits, 1),
                $mapping,
                $current . $letter,
                $combinations
            );
        }

        return $combinations;
    }
}

// Алгоритмическая сложность - O(3^N * 4^M). Так как букв у цифр от 3 до 4 и
// алгоритм рекурсивно перебирает все комбинации букв для всех цифр в строке $digits.
