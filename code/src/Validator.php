<?php

namespace Application;

class Validator
{
    public function controlBrackets(string $string): bool
    {
        // 0. Чистим строку от лишних символов
        $string = preg_replace('/[^()]+/', '', $string);

        // 1. Проверка на четность
        $lenght = strlen($string);
        if ($lenght % 2 != 0) {
            return false;
        }

        // 2. Проверка последовательности на 1-й и N-й символ
        $array = str_split($string, 1);
        if ($array[0] <> '(' || $array[$lenght - 1] <> ')') {
            return false;
        }

        // 3. Количество разных скобок должно быть равным
        $counter = 0;
        foreach ($array as $value) {
            if ($value == '(') {
                $counter++;
            } elseif ($value == ')') {
                $counter--;
            }
            if ($counter < 0) {
                return false;
            }
        }
        return $counter == 0;
    }
}