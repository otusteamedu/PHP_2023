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
        $openCount = 0;
        $closeCount = 0;

        for ($i = 0; $i < strlen($string); $i++) {
            $character = $string[$i];

            if ($character === '(') {
                $openCount++;
            } elseif ($character === ')') {
                $closeCount++;
            }
            if ($closeCount > $openCount || ($i === strlen($string) - 1 && $openCount > $closeCount)) {
                throw new \Exception('Неправильное количество скобок.');
            }
        }

        if ($openCount !== $closeCount) {
            throw new \Exception('Неправильное количество скобок.');
        }
    }
}
