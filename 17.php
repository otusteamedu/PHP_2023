<?php

namespace leetcode17;

class Solution
{
    /**
     * @param String $digits
     * @return String[]
     */
    public function letterCombinations($digits)
    {
        $map = [
            2 => ['a','b','c'],
            3 => ['d','e','f'],
            4 => ['g','h','i'],
            5 => ['j','k','l'],
            6 => ['m','n','o'],
            7 => ['p','q','r','s'],
            8 => ['t','u','v'],
            9 => ['w','x','y','z']
        ];

        if ($digits == '') {
            return [];
        }

        $result = $map[$digits[0]];

        for ($i = 1; $i < strlen($digits); $i++) {
            $tmp = [];
            foreach ($map[$digits[$i]] as $part2) {
                foreach ($result as $part1) {
                    $tmp[] = $part1 . $part2;
                }
            }

            $result = $tmp;
        }

        return $result;
    }
}

$s = new Solution();
$s->letterCombinations("2374");
