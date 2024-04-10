<?php

declare(strict_types=1);

namespace Ashishak\Balancer\code;

class Validator
{
    public static function validateText(string $postVar): bool
    {
        $counter = 0;

        $postVarArray = str_split($postVar);

        foreach ($postVarArray as $value) {
            if ($value == '(') {
                $counter++;
            } elseif ($value == ')') {
                $counter--;
            }
            if ($counter < 0) {
                return false;
            }
        }

        if ($counter === 0) {
            return true;
        } else {
            return false;
        }
    }
}
