<?php

namespace App;

class FractionToDecimal
{
    /**
     * Сложность O(n)
     *
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    public function fractionToDecimal(int $numerator, int $denominator)
    {
        if ($denominator === 0) {
            return "0";
        }

        $negative = "";

        if ($numerator * $denominator < 0) {
            $negative = "-";
        }

        $numerator = (int) abs($numerator);
        $denominator = (int) abs($denominator);

        $integer = floor($numerator / $denominator);
        $rest = $numerator % $denominator;
        $decimal = ".";
        $hash = [];
        while ($rest !== 0) {
            $curDecimal = floor(($rest * 10) / $denominator);
            $hash[$rest] = strlen($decimal); // save the index
            $rest = $rest * 10 % $denominator;
            if (isset($hash[$rest])) {
                $decimal = substr($decimal, 0, $hash[$rest]) . "(" . substr($decimal, $hash[$rest]) . $curDecimal . ")";
                break;
            }

            $decimal .= "" . $curDecimal;
        }
        $a = $decimal === "." ? "" : $decimal;

        return $negative . $integer  . $a;
    }
}
