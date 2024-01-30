<?php

class Solution {

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits) {
        $result = [];
        if (empty($digits)) {
            return $result;
        }

        $phoneMap = [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z'],
        ];

        $this->backtrack($result, $phoneMap, $digits, "", 0);
        return $result;
    }

    function backtrack(&$result, $phoneMap, $digits, $current, $index) {
        if ($index === strlen($digits)) {
            $result[] = $current;
            return;
        }

        $digit = $digits[$index];
        foreach ($phoneMap[$digit] as $letter) {
            $this->backtrack($result, $phoneMap, $digits, $current . $letter, $index + 1);
        }
    }
}