<?php

namespace App;

class Solution
{
/**
 * @param String $digits
 * @return String[]
 */
    public function letterCombinations($digits)
    {
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
        $output = [];
        if (empty($digits)) {
            return $output;
        }
        $string = str_split($digits);
        if (empty($string)) {
            return $output;
        }
        foreach ($string as $key => $value) {
            if (empty($output)) {
                $output = $letters[$value];
            } else {
                $temp = [];
                foreach ($output as $key2 => $value2) {
                    foreach ($letters[$value] as $key3 => $value3) {
                        $temp[] = $value2 . $value3;
                    }
                }
                $output = $temp;
            }
        }
        return $output;
    }
}
