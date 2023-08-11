<?php

namespace Vendor\class;

/**
 * url https://leetcode.com/problems/letter-combinations-of-a-phone-number/
 * сложность линейная, нет повторных прохождений по одним и тем же элементам массива
 */

class Solution
{
    /**
     * @param String $digits
     * @return String[]
     */
    public function letterCombinations($digits)
    {
        $combine = [];
        foreach (static::combine("", $digits) as $combineStr) {
            $combine[] = $combineStr;
        }
        return $combine;
    }
    public static function combine($str, $digits = '')
    {
        $curD = $digits[0];
        $symbols = static::makeSymbols($curD);
        $digitsNew = substr($digits, 1);
        foreach ($symbols as $symbol) {
            $combineStroke = $str . $symbol;
            if (strlen($digitsNew) > 0) {
                foreach (static::combine($combineStroke, $digitsNew) as $str2) {
                    yield $str2;
                }
            } else {
                yield $combineStroke;
            }
        }
    }
    public static function makeSymbols($curD)
    {
        $symbolsAll = [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z'],
        ];
        return $symbolsAll[$curD];
    }
}
