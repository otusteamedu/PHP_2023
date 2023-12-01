<?php

declare(strict_types=1);

namespace App\FractionToRecurringDecimal;

class Solution
{
    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    public function fractionToDecimal(int $numerator, int $denominator): string
    {
        if ($numerator === 0) {
            return "0";
        }

        $result = [];

        if ($numerator < 0 || $denominator < 0) {
            $result[] = "-";
        }

        $result[] = strval(intval($numerator / $denominator));

        $remainder = $numerator % $denominator;
        if ($remainder === 0) {
            return implode("", $result);
        }

        $result[] = ".";

        $remainderDict = [];
        while ($remainder !== 0) {
            if (array_key_exists($remainder, $remainderDict)) {
                array_splice($result, $remainderDict[$remainder], 0, "(");
                $result[] = ")";
                break;
            }

            $remainderDict[$remainder] = count($result);
            $remainder *= 10;
            $result[] = strval(intval($remainder / $denominator));
            $remainder %= $denominator;
        }

        return implode("", $result);
    }
}

// Сложность - O(n), где n - количество цифр в дробной части
