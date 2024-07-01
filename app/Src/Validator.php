<?php
declare(strict_types=1);
namespace App\Src;

use Exception;

class Validator
{

    public function validate(string $string = "")
    {
        if (empty($string)) {
            $this->error("Пустая строка. Пожалуйста, заполните POST параметр 'string'");
        }
        if ($string[0] === '(' && $string[-1] === ')') {
            $stack = [];
            $chars = str_split($string);
            foreach($chars as $key => $char) {
                if ($char === '(') {
                    array_push($stack, '(');
                } else if ($char === ')') {
                    if (count($stack)) {
                        array_pop($stack);
                    } else {
                        $this->error("Отсутствует открывающая скобка для ')' (позиция " .  ($key + 1) . ')');
                    }
                } else {
                    $this->error("Недопустимый символ '" . $char . "'. Используйте только '(' и  ')'");
                }
            }
            if (count($stack)) {
                $this->error("Не хватает " . (count($stack) . " закрывающих скобок"));
            } else {
                return true;
            }

        } else {
            $this->error("Некорректное начало или конец строки");
        }

    }

    private function error(string $message = "error") 
    {
        throw new Exception($message);
    }

}
