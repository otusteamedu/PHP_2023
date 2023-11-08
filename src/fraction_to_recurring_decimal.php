<?php

declare(strict_types=1);

function fractionToDecimal(int $numerator, int $denominator): string
{
    if ($numerator === 0) {
        return "0";
    }
    $result = '';
    if ($numerator < 0 ^ $denominator < 0) {
        $result .= '-';
    }
    $numerator = abs($numerator);
    $denominator = abs($denominator);
    $wholePart = (int)($numerator / $denominator);
    $result .= $wholePart;
    $remainder = $numerator % $denominator;
    if ($remainder === 0) {
        return $result;
    }
    $result .= '.';
    $result .= fractionToRecurringDecimal($remainder, $denominator);

    return $result;
}

function fractionToRecurringDecimal(int $remainder, int $denominator): string
{
    $seenRemainders = [];
    $result = '';
    while ($remainder !== 0) {
        if (isset($seenRemainders[$remainder])) {
            $repeatIndex = $seenRemainders[$remainder];
            return substr($result, 0, $repeatIndex) . '(' . substr($result, $repeatIndex) . ')';
        }
        $seenRemainders[$remainder] = strlen($result);
        $remainder *= 10;
        $result .= intdiv($remainder, $denominator);
        $remainder %= $denominator;
    }
    return $result;
}

$numerator = 4;
$denominator = 333;

echo "Сложность: O(n)";
echo fractionToDecimal($numerator, $denominator);
