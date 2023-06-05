<?php

declare(strict_types=1);

namespace Dpankratov\Hw4\Requests;

use Exception;

class StringValidation
{
    public function validation(string $str)
    {
        if (empty($str)) {
            throw new Exception('Введена пустая строка! Необходимо ввести символы скобок в поле');
        } else if (!preg_match('/^[()]+$/', $str)) {
            throw new Exception('Строка должна содержать только символы скобок, ()');
        }

        $diff = 0;
        for ($i = 0; $i < strlen($str); $i++) {
            $diff = $str[$i] === '(' ? ++$diff : --$diff;
            if ($diff < 0) {
                throw new Exception("Закрывающая скобка в позиции $i не сочетается с открывающей!");
            }
        }

        if ($diff !== 0) {
            throw new Exception("Открывающих скобок больше, чем закрывающих!");
        }

        return true;
    }
}
