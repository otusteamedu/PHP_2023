<?php

declare(strict_types=1);

namespace App\Task2;

class Solution
{
    /**
     * @time O(n)
     * @memory O(1)
     */
    public function fractionToDecimal(int $numerator, int $denominator): string
    {
        $res = '';
        if (($numerator < 0 && $denominator > 0) || ($numerator > 0 && $denominator < 0)) {
            $res = '-';
            $numerator = abs($numerator);
            $denominator = abs($denominator);
        }
        $res .= (int)($numerator / $denominator);

        $frac = $numerator % $denominator;
        if (!$frac) {
            return $res;
        }

        $res .= '.';
        $hmap = [];
        $hmap[$frac] = strlen($res);

        while ($frac !== 0) {
            $frac *= 10;
            $next = (int)($frac / $denominator);
            $res .= $next;
            $frac = $frac % $denominator;
            if (isset($hmap[$frac]) && ($hmap[$frac] !== end($hmap) || ($hmap[$frac] === end($hmap) && $frac === array_key_last($hmap)))) {
                return substr_replace($res, '(', $hmap[$frac], 0) . ')';
            }
            $hmap[$frac] = strlen($res);
        }

        return $res;
    }
}

$solution = new Solution();
echo $solution->fractionToDecimal(-50, 8);
