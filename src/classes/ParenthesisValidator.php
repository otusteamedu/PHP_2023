<?php

namespace Klobkovsky\App;

class ParenthesisValidator
{
    public static function validate($string)
    {
        try {
            if (empty($string)) {
                throw new \Exception('Строка пустая');
            }

            $contOfParenthesis = 0;

            foreach (str_split($string) as $symbol) {
                if ($symbol === '(') {
                    $contOfParenthesis++;
                } elseif ($symbol === ')') {
                    $contOfParenthesis--;
                }

                if ($contOfParenthesis < 0) {
                    throw new \Exception('Строка не корректна');
                }
            }

            if ($contOfParenthesis !== 0) {
                throw new \Exception('Строка не корректна');
            }
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
