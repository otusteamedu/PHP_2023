<?php
class Solution {

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits) {
        if (empty($digits)) return [];
        $letters = [
            '2' => ['a','b','c'],
            '3' => ['d','e','f'],
            '4' => ['g','h','i'],
            '5' => ['j','k','l'],
            '6' => ['m','n','o'],
            '7' => ['p','q','r','s'],
            '8' => ['t','u','v'],
            '9' => ['w','x','y','z']
        ];

        $numbers = str_split($digits);
        $result = [];
        foreach ($numbers AS $number) {
            if (empty($result)) {
                $result = $letters[$number];
            } else {
                $new_result = [];
                foreach($result AS $key => $val) {
                    foreach ($letters[$number] AS $letter) {
                        $new_result[] = $val . $letter;
                    }
                }
                $result = $new_result;
            }
        }

        return $result;
    }
}
?>