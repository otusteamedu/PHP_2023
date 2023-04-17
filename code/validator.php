<?php

function bracketsValidate(string $string): bool
{
    $open = 0;
    $closed = 0;
    $splits = str_split($string);
    foreach ($splits as $bracket) {
        if ($bracket === '(') {
            $open++;
        } elseif ($bracket === ')') {
            $closed++;
        }
    }

    if ($open !== $closed) {
        return false;
    }
    return true;
}

function emptyValidate(string $string): bool
{
    return empty($string);
}
