<?php

declare(strict_types=1);

namespace Vp;

class Solution
{
    public function fractionToDecimal(int $numerator, int $denominator): string
    {
        if ($numerator === 0) {
            return '0';
        }

        $result = '';
        $negativeSign = false;
        if (($numerator < 0) || ($denominator < 0)) {
            $negativeSign = true;
        }
        if (($numerator < 0) && ($denominator < 0)) {
            $negativeSign = false;
        }

        if ($negativeSign) {
            $result .= '-';
        }

        $numerator = abs($numerator);
        $denominator = abs($denominator);

        $intDiv = intdiv($numerator, $denominator);

        $result .= $intDiv;

        if (($numerator % $denominator) === 0) {
            return $result;
        }

        $result .= '.';

        $remDiv = $numerator % $denominator * 10;
        $hash = [];

        while ($remDiv != 0) {
            if (array_key_exists($remDiv, $hash)) {
                $index = $hash[$remDiv];
                $part1 = substr($result, 0, $index);
                $part2 = "(" . substr($result, $index, strlen($result)) . ")";
                return $part1 . $part2;
            }

            $hash[$remDiv] = strlen($result);
            $temp = intdiv($remDiv, $denominator);
            $result .= $temp;

            $remDiv = ($remDiv % $denominator) * 10;
        }
        return $result;
    }
}
