<?php

declare(strict_types=1);

class Solution {

    public $result = [];

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits) {
        if(strlen($digits) == 0) {
            return [];
        }

        $keyboard = [
            2 => range('a', 'c'),
            3 => range('d', 'f'),
            4 => range('g', 'i'),
            5 => range('j', 'l'),
            6 => range('m', 'o'),
            7 => range('p', 's'),
            8 => range('t', 'v'),
            9 => range('w', 'z'),
        ];

        return $this->recursive(0, $digits, $keyboard);
    }

    function recursive($index, $digits, $keyboard, $currenctResult = ''){

        foreach ($keyboard[$digits[$index]] as $currentSymbol)
        {
            if (isset($keyboard[$digits[$index + 1]]))
            {
               $this->recursive($index + 1, $digits, $keyboard, $currenctResult . $currentSymbol);

            } else {
                $this->result[] = $currentSymbol . $currenctResult;
            }
        }
        return $this->result;
    }
}