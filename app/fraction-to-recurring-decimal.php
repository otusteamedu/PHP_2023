<?php

declare(strict_types=1);

namespace App;

class Solution
{
    public function fractionToDecimal(int $numerator, int $denominator): string
    {
        $result = $numerator / $denominator;
        $prefix = $result < 0 ? '-' : '';

        if ($result === 0) {
            return "0";
        }

        $result = abs($result);
        $numerator = abs($numerator);
        $denominator = abs($denominator);

        if ($numerator % $denominator === 0) {
            return $prefix . $result;
        }

        $remainder = $numerator % $denominator;
        $int = intval($numerator / $denominator);
        $fractional = '';
        $hash = [];
        $i = 0;

        while ($remainder !== 0) {
            if (array_key_exists($remainder, $hash)) {
                $from = $hash[$remainder];

                return $prefix . $int . '.' . substr($fractional, 0, $from) . '(' . substr($fractional, $from, $i - $from) . ')';
            }

            $hash[$remainder] = $i;
            $i++;

            $remainder = $remainder * 10;
            $fractional .= (int) ($remainder / $denominator);
            $remainder = $remainder % $denominator;
        }

        return $prefix . $int . '.' . $fractional;
    }
}
