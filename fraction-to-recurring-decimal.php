<?php

function fractionToDecimal($numerator, $denominator)
{
    if ($numerator % $denominator == 0) {
        return strval($numerator / $denominator);
    }

    if ($numerator * $denominator >= 0) {
        $sign = '';
    } else {
        $sign = '-';
    }

    $numerator = abs($numerator);
    $denominator = abs($denominator);

    $result = $sign . floor($numerator / $denominator) . '.';
    $numerator = $numerator % $denominator;

    $i = 0;
    $part = '';

    $hash = [$numerator => $i];

    while ($numerator % $denominator) {
        $numerator = $numerator * 10;
        $i++;
        $remainder = $numerator % $denominator;

        $part = $part . floor($numerator / $denominator);

        if (isset($hash[$remainder])) {
            $part = substr($part, 0, $hash[$remainder]) . '(' . substr($part, $hash[$remainder]) . ')';
            return $result . $part;
        }

        $hash[$remainder] = $i;
        $numerator = $remainder;
    }

    return $result . $part;
}
