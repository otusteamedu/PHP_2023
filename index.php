<?php

declare(strict_types=1);

function validateEmail(array $strings): array
{
    $valid = [];
    foreach ($strings as $string) {
        $words = explode(' ', preg_replace('/^ +| +$|( ) +/m', '$1', $string));
        foreach ($words as $word) {
            if (filter_var($word, FILTER_VALIDATE_EMAIL) && checkdnsrr(explode('@', $word)[1])) {
                $valid[] = $word;
            }
        }
    }
    return $valid;
}
