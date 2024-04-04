<?php

namespace Dmatrenin\Bracket;

use Exception;

class Validator
{
    /**
     * @throws Exception
     */
    public static function validate(string $bracket): string
    {
        $counter = 0;
        $bracket = preg_replace('/[^()]/', '', $bracket);

        if ($bracket === '') {
            throw new Exception("Пустая строка", 400);
        }

        foreach (str_split($bracket) as $char) {
            if ($char === '(') {
                $counter++;
            } elseif ($char === ')') {
                $counter--;
            }

            if ($counter < 0) {
                throw new Exception("Не хватает открывающей скобки", 400);
            }
        }

        if ($counter > 0) {
            throw new Exception("Не хватает зактывающей скобки", 400);
        }

        return $bracket;
    }
}
