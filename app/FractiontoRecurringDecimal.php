<?php

declare(strict_types=1);

class Solution
{
    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    public function fractionToDecimal($numerator, $denominator)
    {
        if ($numerator == 0) {
            return "0";
        }

        $output = '';

        if (($numerator < 0 && $denominator > 0) || ($numerator > 0 && $denominator < 0)) {
            $output .= '-';
        }

        $numerator = abs($numerator);
        $denominator = abs($denominator);
        $output .= intval($numerator / $denominator);

        if ($numerator % $denominator != 0) {
            $output .= '.';
        }

        $remainder = $numerator % $denominator;
        $hash = [];

        while ($remainder != 0 && !isset($hash[$remainder])) {
            $hash[$remainder] = strlen($output);
            $remainder *= 10;
            $output .= intval($remainder / $denominator);
            $remainder %= $denominator;
        }

        if ($remainder == 0) {
            return $output;
        } else {
            $index = $hash[$remainder];
            return substr($output, 0, $index) . '(' . substr($output, $index) . ')';
        }
    }
}
