<?php

namespace Romank\Php2023;

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
            $character = $string[$i];

            if ($character === '(') {
                $count++;
            } elseif ($character === ')') {
                $count--;
            }
        }

        if ($count !== 0) {
            throw new \Exception('Неправильное количество скобок.');
        }
    }
}
