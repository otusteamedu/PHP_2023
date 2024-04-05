<?php


class Solution
{
    function fractionToDecimal($numerator, $denominator) {
        if ($numerator == 0) return "0";

        $result = "";

        if (($numerator < 0) ^ ($denominator < 0)) {
            $result .= "-";
        }

        $numerator = abs($numerator);
        $denominator = abs($denominator);

        $result .= intval($numerator / $denominator);

        if ($numerator % $denominator != 0) {
            $result .= ".";

            $map = [];

            $remainder = $numerator % $denominator;

            while ($remainder != 0) {
                if (isset($map[$remainder])) {
                    $start = $map[$remainder];
                    $part1 = substr($result, 0, $start);
                    $part2 = substr($result, $start);

                    return $part1 . "(" . $part2 . ")";
                }

                $map[$remainder] = strlen($result);

                $remainder *= 10;

                $result .= intval($remainder / $denominator);

                $remainder %= $denominator;
            }
        }

        return $result;
    }
}

