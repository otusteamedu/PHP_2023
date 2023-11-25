<?php

declare(strict_types=1);

namespace Services;

class StringValidator
{
    public function isValidString(string $str): bool
    {
        $count = 0;

        for ($i = 0; $i < strlen($str); $i++) {
            if ($str[$i] == '(') {
                $count++;
            } elseif ($str[$i] == ')') {
                $count--;
            }
            if ($count < 0) {
                return false;
            }
        }
        return $count == 0;
    }
}
