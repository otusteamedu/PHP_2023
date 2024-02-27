<?php

declare(strict_types=1);

namespace App;

// сложность O(n)
class Solution
{

    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    function fractionToDecimal(int $numerator, int $denominator): string
    {
        $result = $numerator / $denominator;
        $prefix = $result < 0 ? '-' : '';
        $result = abs($result);

        if ($result === (int)$result) {
            return $prefix . (string)$result;
        }

        $numerator = abs($numerator);
        $denominator = abs($denominator);

        $remainder = $numerator % $denominator;
        $int = (int)($numerator / $denominator);
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
            $fractional .= (string)(int)($remainder / $denominator);
            $remainder = $remainder % $denominator;
        }

        return $prefix . $int . '.' . $fractional;
    }
}