<?php

namespace Dev\Php2023;

use Exception;

class Validator
{
    /**
     * @throws Exception
     */
    public function validateString($string)
    {
        if (empty($string)) {
            throw new Exception('Строка скобок пуста.');
        }

        $this->validateBrackets($string);
    }

    /**
     * @throws Exception
     */
    private function validateBrackets($string): void
    {
        $count = 0;

        for ($i = 0, $iMax = strlen($string); $i < $iMax; $i++) {
            $character = $string[$i];

            if ($character === '(') {
                $count++;
            } elseif ($character === ')') {
                $count--;
            }
        }

        if ($count !== 0) {
            throw new Exception('Неправильное количество скобок.');
        }
    }
}