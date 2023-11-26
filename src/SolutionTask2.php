<?php
/**
 * https://leetcode.com/problems/fraction-to-recurring-decimal/
 */

namespace App;

class SolutionTask2
{
    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    public function fractionToDecimal(int $numerator, int $denominator): string
    {
        if ($numerator == 0) return "0";
        $result = "";

        if (
            $numerator < 0 && $denominator > 0
            || $numerator > 0 && $denominator < 0
        ) {
            $result .= "-";
        }

        $divisor = abs($numerator);
        $dividend = abs($denominator);

        $result .= floor($divisor / $dividend);
        $divisor %= $dividend;

        if ($divisor === 0) return $result;
        $result .= ".";

        $map = [];

        while ($divisor !== 0) {
            $map[$divisor] = strlen($result);
            $divisor *= 10;
            $result .= floor($divisor / $dividend);
            $divisor %= $dividend;

            if (isset($map[$divisor])) {
                $i = $map[$divisor];
                $str1 = substr($result, 0, $i);
                $str2 = substr($result, $i);

                return "{$str1}({$str2})";
            }
        }

        return $result;
    }
}
