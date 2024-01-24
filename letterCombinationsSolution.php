<?php

class Solution
{
    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits) {
        if ($digits === '') {
            return [];
        }

        $count = strlen($digits);
        $buttons = [
            "0" => [],
            "1" => [],
            "2" => ['a', 'b', 'c'],
            "3" => ['d', 'e', 'f'],
            "4" => ['g', 'h', 'i'],
            "5" => ['j', 'k', 'l'],
            "6" => ['m', 'n', 'o'],
            "7" => ['p', 'q', 'r', 's'],
            "8" => ['t', 'u', 'v'],
            "9" => ['w', 'x', 'y', 'z']
        ];

        if ($count === 1) {
            return $buttons[$digits[0]];
        }

        $result = $buttons[$digits[0]];

        for ($i = 1; $i < $count; $i++) {
            $res = [];
            foreach ($buttons[$digits[$i]] as $buttonLetters) {
                foreach ($result as $resultLetters) {
                    $res[] = $resultLetters . $buttonLetters;
                }
            }
            $result = $res;
        }

        return $result;
    }
}
