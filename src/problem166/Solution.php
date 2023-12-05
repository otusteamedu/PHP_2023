<?php

namespace src\problem166;

class Solution
{
    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    public function fractionToDecimal(int $numerator, int $denominator): string
    {
        $dr = (float)(($numerator / $denominator). '');
        if (((float)($dr * $denominator)) === ((float)$numerator)) {
            return ($numerator / $denominator);
        }

        $numerator = ($numerator < 0) ? $numerator * -1 : $numerator;
        $denominator = ($denominator < 0) ? $denominator * -1 : $denominator;
        return sprintf(
            "%s%s.%s",
            ($dr < 0) ? '-': '',
            intdiv($numerator, $denominator),
            $this->subRecursive(
                $numerator,
                $denominator,
                [],
                $numerator % $denominator
            )
        );
    }

    private function subRecursive($ch, $zn, $all, $part): string
    {
        if (isset($all[$part])) {
            $key = array_search($part, array_keys($all), true);

            $outBefore = implode('', array_slice($all, 0, $key));

            $out = implode('', array_slice($all, $key));

            if (31 <= strlen($outBefore)) {
                return $outBefore;
            }
            return $outBefore . '(' . $out . ')';
        }

        $mn = $part * 10;
        //if (PHP_INT_MAX < $mn) {
        //    return 'exception';
        //}
        $all[$part] = intdiv($mn, $zn);

        return $this->subRecursive($mn, $zn, $all, $mn % $zn);
    }
}
