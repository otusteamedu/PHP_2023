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
        } else if ($str[0] === ')' || $str[-1] === '(') {
            throw new Exception('Строка должна начинаться с открывающей скобки ( и заканчиваться закрывающей )');
        }

        $counter1 = 0;
        $counter2 = 0;

        for ($i = 0; $i < strlen($str); $i++) {
            if ($str[$i] === '(') {
                $counter1++;
            }
            else $counter2++;
        }

        if ($counter1 > $counter2) {
            throw new Exception("Открывающих скобок больше, чем закрывающих!");
        }
        else if ($counter2 > $counter1) {
            throw new Exception("Закрывающих скобок больше, чем открывающих!");
        }

        return true;
    }
}
