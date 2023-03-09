<?php

namespace app\code\helpers;

use Exception;

class Validator
{
    public string $string;

    public function __construct($string)
    {
        $this->string = $string;
    }

    /**
     * @throws Exception
     */
    public function checkCorrect()
    {
        if (empty($this->string)) {
            throw new Exception("Неверный запрос. Пустая строка", 400);
        }
        $symbols = preg_replace('/\(|\)/', '', $this->string);
        if (!empty($symbols)) {
            throw new Exception("Неверный запрос. Присутствуют символы, отличные от скобок: $symbols", 400);
        }
        if ($this->unpairedBrackets() === false) {
            throw new Exception("Есть лишние скобки", 400);
        }
    }

    private function unpairedBrackets(): bool
    {
        if (strlen($this->string) % 2 !== 0) {
            return false;
        }
        for ($i = strlen($this->string) / 2; $i >= 0 && strlen($this->string) > 0; $i--) {
            $this->string = str_replace('()', '', $this->string);
            if (strlen($this->string) == 0) return true;
        }

        return false;
    }
}