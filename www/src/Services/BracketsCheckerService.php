<?php

declare(strict_types=1);

namespace Dimal\Homework4\Services;

use Exception;

class BracketsCheckerService
{
    public static function checkBrackets($string): bool
    {
        $open_bracket_count = 0;
        for ($i = 0; $i < strlen($string); $i++) {
            $char = $string[$i];
            if ($char == '(') {
                $open_bracket_count++;
            }

            if ($char == ')') {
                $open_bracket_count--;
            }

            if ($open_bracket_count < 0) {
                throw new Exception("Лишняя закрывающая скобка, позиция: " . ($i + 1));
                return false;
            }
        }

        if ($open_bracket_count) {
            throw new Exception("Не хватает закрывающих скобок в количестве: " . $open_bracket_count . ' шт');
            return false;
        }

        return true;
    }
}
