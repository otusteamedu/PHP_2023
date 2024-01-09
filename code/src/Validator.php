<?php

declare(strict_types=1);

namespace Application;

class Validator
{
    public function validate(string $string): string
    {
        $empty = $this->stringIsEmpty($string);
        $bracketsValid = $this->bracketsInStringIsValid($string);

        if (!$empty && $bracketsValid) {
            http_response_code(200);
            return 'всё хорошо';
        } else {
            http_response_code(400);
            return 'всё плохо';
        }
    }

    public function stringIsEmpty(string $string): bool
    {
        if (empty($string)) {
            return true;
        }

        return false;
    }

    public function bracketsInStringIsValid(string $string): bool
    {
        $counter = 0;
        foreach (str_split($string) as $char) {
            if ($char === '(') {
                $counter++;
            } elseif ($char === ')') {
                $counter--;
                if ($counter < 0) {
                    return false;
                }
            } else {
                return false;
            }
        }
        return $counter === 0;
    }
}
