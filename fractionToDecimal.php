<?php

class Solution
{
    /**
     * Сложность данного алгоритма - линейная O(n).
     *
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    function fractionToDecimal(int $numerator, int $denominator): string
    {
        if ($denominator == 0) return "0";
        $negative = "";
        if ($numerator * $denominator < 0) $negative = "-";

        $numerator = abs($numerator);
        $denominator = abs($denominator);

        $integer = floor($numerator / $denominator);
        $rest = $numerator % $denominator;
        $decimal = ".";
        $hash = [];
        while ($rest != 0) {
            $curDecimal = floor(($rest * 10) / $denominator);
            $hash[$rest] = strlen($decimal); // save the index
            $rest = $rest * 10 % $denominator;
            if (isset($hash[$rest])) {
                $decimal = substr($decimal, 0, $hash[$rest]) . "(" . substr($decimal, $hash[$rest]) . $curDecimal . ")";
                break;
            } else {
                $decimal .= "" . $curDecimal;
            }
        }
        $a = $decimal == "." ? "" : $decimal;

        return $negative . $integer  . $a;
    }
}

$solution = new Solution();
echo  $solution->fractionToDecimal(1,2);