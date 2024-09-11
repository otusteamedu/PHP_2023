<?php

namespace Alexgaliy\AppValidator;

class Validator
{
    public function validateString($string)
    {
        if (empty($string)) {
            throw new \Exception('Строка скобок пуста.');
        }

        $this->validateBrackets($string);
    }

    private function validateBrackets($string): void
    {
        $count = 0;

        for ($i = 0; $i < strlen($string); $i++) {
            if ($string['0'] === ')') {
                throw new \Exception('Строка начинается с закрывающей скобки.');
                break;
            };
            $symbol = $string[$i];
            if ($symbol === '(') {
                $count++;
            } elseif ($symbol === ')') {
                $count--;
            }
        }

        if ($count !== 0) {
            throw new \Exception('Неправильное количество скобок.');
        }
    }
}
