<?php

namespace app;
class Validator
{
    public static function validateBraces(string $brace): bool
    {
        if (mb_strlen($brace) == 0) {
            return false;
        }

        $count = 0;

        foreach (str_split($brace) as $char) {
            if (!($char == "(" || $char == ")")) {
                return false;
            }

            if ($char == "(") {
                $count++;
            } else {
                $count--;
            }

            if ($count < 0) {
                return false;
            }
        }

        return $count == 0;
    }
}