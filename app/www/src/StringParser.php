<?php

namespace Root\Www;

class StringParser
{
    private $string;
    private $is_valid = true;
    private $message  = null;

    public function __construct($string)
    {
        $this->string = $string;
    }

    public function run()
    {
        if (empty($this->string)) {
            $this->is_valid = false;
            $this->message  = "Ошибка: значение 'string' не может быть пустым!";
            return;
        }
        if (strpos($this->string, '(') > strpos($this->string, ')')) {
            $this->is_valid = false;
            $this->message  = "Ошибка: неверное расположение ')'!";
            return;
        }
        str_replace('(', 1, $this->string, $count_open);
        str_replace(')', 2, $this->string, $count_close);
        $val =  $count_open - $count_close;
        if ($val != 0) {
            $this->is_valid = false;
            $count = abs($val);
            $extra = $val > 0 ? "'('" : "')'";
            $this->message  = "Ошибка: значение 'string' содержит лишние скобки [{$extra}:{$count} шт.]";
            return;
        }
        $this->message = "Строка [{$this->string}] обработана успешно.";
    }

    public function validate()
    {
        return $this->is_valid;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
