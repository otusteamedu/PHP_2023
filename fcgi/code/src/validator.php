<?php

declare(strict_types=1);

function checkBrackets(string $string): bool
{
    $counter = 0;
    for ($i = 0; $i < mb_strlen($string); $i++) {
        if ($string[$i] == '(') {
            $counter++;
        } else {
            $counter--;
        }

        if ($counter < 0) {
            return false;
        }
    }

    return $counter === 0;
}

function checkPattern(string $string): bool
{
    preg_match('/[^)(]/', $string, $matches);
    return empty($matches);
}
