<?php

class Solution {

    /**
     * сложность O(n * 4^n) - для цифр 7 и 9 используются 4 буквы
     *
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits): array
    {
        $lookup = [
            '2' => 'abc',
            '3' => 'def',
            '4' => 'ghi',
            '5' => 'jkl',
            '6' => 'mno',
            '7' => 'pqrs',
            '8' => 'tuv',
            '9' => 'wxyz',
        ];

        if (strlen($digits) === 0) {
            return [];
        }

        $output = [''];

        for($i = 0; $i < strlen($digits); $i++) {
            $tmp = [];
            $digit = $digits[$i];

            for($j = 0; $j < strlen($lookup[$digit]); $j++) {
                $char = $lookup[$digit][$j];

                for($k = 0; $k < count($output); $k++) {
                    $tmp[] = $output[$k] . $char;
                }
            }

            $output = $tmp;
        }

        return $output;
    }
}