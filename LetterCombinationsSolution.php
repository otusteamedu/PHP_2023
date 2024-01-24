<?php

class Solution
{

    /**
     * @param String $digits
     * @return String[]
     */

    private $letmap = [
        2 => 'abc',
        3 => 'def',
        4 => 'ghi',
        5 => 'jkl',
        6 => 'mno',
        7 => 'pqrs',
        8 => 'tuv',
        9 => 'wxyz'
    ];

    function letterCombinations($digits)
    {
        if (!$digits) {
            return [];
        }

        $numarr = str_split($digits);
        return $this->makeRecursion($numarr, 0);
    }

    private function makeRecursion($digits, $pos)
    {
        $ret = [];
        $str = $this->letmap[$digits[$pos]];
        $n = strlen($str);

        for ($i = 0; $i < $n; $i++) {
            $elem = $str[$i];
            if (count($digits) > $pos + 1) {
                $subarr = $this->makeRecursion($digits, $pos + 1);
                foreach ($subarr as $subelem) {
                    array_push($ret, $elem . $subelem);
                }
            } else {
                array_push($ret, $elem);
            }
        }

        return $ret;
    }
}
