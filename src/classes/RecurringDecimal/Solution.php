<?php

namespace Klobkovsky\App\RecurringDecimal;

class Solution
{

    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    public static function fractionToDecimal(int $numerator, int $denominator): string
    {
        if ($denominator === 0) {
            throw new \Exception('Знаменатель не должен быть равен 0');
        }

        $divisionResult = [];
        $mod = $numerator % $denominator;
        $period = '';
        $counter = 1;

        while ($mod != 0) {
            if (isset($divisionResult[$mod]))
                break;

            $divisionResult[$mod] = $counter;
            $mod *= 10;
            $explode = explode('.', $mod / $denominator);
            $period .= $explode[0];
            $mod %= $denominator;
            $counter++;
        }

        if ($mod != 0) {
            $part = explode('.', $numerator / $denominator);

            return $part[0] . '.' . substr($period, 0, $divisionResult[$mod] - 1) . '(' . substr($period, $divisionResult[$mod] - 1) . ')';
        } else
            return (string)($numerator / $denominator);
    }
}
