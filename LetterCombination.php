<?php

namespace app\leetcode\LetterCombination;

class LetterCombination
{
    /**
     * @param  String  $digits
     *
     * @return String[]
     */
    public function letterCombinations(string $digits): array
    {
        if ($digits === '') {
            return [];
        }

        $hash = [
            "2" => ['a', 'b', 'c'],
            "3" => ['d', 'e', 'f'],
            "4" => ['g', 'h', 'i'],
            "5" => ['j', 'k', 'l'],
            "6" => ['m', 'n', 'o'],
            "7" => ['p', 'q', 'r', 's'],
            "8" => ['t', 'u', 'v'],
            "9" => ['w', 'x', 'y', 'z']
        ];

        if (strlen($digits) === 1) {
            return $hash[$digits[0]];
        }

        $res = $hash[$digits[0]];
        for ($i = 1, $iMax = strlen($digits); $i < $iMax; $i++) {
            $res = $this->twoDigits($res, $hash[$digits[$i]]);
        }

        return $res;
    }

    public function twoDigits($digit1, $digit2): array
    {
        $res = [];
        foreach ($digit1 as $iValue) {
            foreach ($digit2 as $jValue) {
                $res[] = $iValue.$jValue;
            }
        }

        return $res;
    }
}
