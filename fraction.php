<?php

namespace Leetcode;

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
            return "0"; // Если в числителе 0, возвращаем "0".
        }

        $result = '';

        // Определяем знак результата.
        if (($numerator < 0) ^ ($denominator < 0)) {
            $result .= '-';
        }

        $numerator = abs($numerator);
        $denominator = abs($denominator);

        // Добавляем целую часть.
        $result .= (string)(int)($numerator / $denominator);

        $remainder = $numerator % $denominator;
        if ($remainder == 0) {
            return $result; // Если остаток от деления 0, возвращаем результат.
        }

        $result .= '.'; // Добавляем десятичную точку.

        $fractionalPart = '';
        $remainderPositions = []; // Массив для хранения позиций остатков от деления.

        while ($remainder != 0) {
            if (isset($remainderPositions[$remainder])) {
                // Если остаток от деления уже встречался, значит, дробь периодическая.
                $startIndex = $remainderPositions[$remainder];
                $nonRepeatingPart = substr($fractionalPart, 0, $startIndex);
                $repeatingPart = substr($fractionalPart, $startIndex);
                return $result . $nonRepeatingPart . '(' . $repeatingPart . ')';
            }

            $remainderPositions[$remainder] = strlen($fractionalPart);
            $remainder *= 10;
            $fractionalPart .= (string)(int)($remainder / $denominator);
            $remainder %= $denominator;
        }

        return $result . $fractionalPart;
    }
}
