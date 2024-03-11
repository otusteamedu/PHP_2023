<?php
class Solution {

    /**
     * Сложность O(n)
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    function fractionToDecimal($numerator, $denominator) {
        if ($denominator === 0)
            throw new Exception("Деление на 0 запрещено!");

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
$result = $solution->fractionToDecimal(4,333);
print_r($result);