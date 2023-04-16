<?php

namespace Leetcode;

class Solution
{
    public function letterCombinations(string $digits): array
    {
        $n = strlen($digits);
        if ($n === 0) {
            return [];
        }

        $hash = [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z'],
        ];


        if ($n === 1) {
            return $hash[$digits[0]];
        }

        $res = $hash[$digits[0]];
        for ($i = 1; $i < $n; $i++) {
            $digit = $digits[$i];
            $res = $this->cartesianProduct($res, $hash[$digit]);
        }

        return $res;
    }

    public function cartesianProduct(array $digit1, array $digit2): array
    {
        $res = [];
        for ($i = 0; $i < count($digit1); $i++) {
            for ($j = 0; $j < count($digit2); $j++) {
                $res[] = $digit1[$i] . $digit2[$j];
            }
        }
        return $res;
    }
}
