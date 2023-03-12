<?php

namespace app\helpers;

use Exception;

class Validator
{
    public ?string $string = null;

    public function __construct()
    {
        $this->string = $_POST['string'] ?? null;
    }

    public function checkString()
    {
        if (!is_null($this->string)) {
            try {
                $this->checkCorrect();
                return 'Скобки корректны.';
            } catch (Exception $e) {
                http_response_code($e->getCode());
                return $e->getMessage();
            }
        }
        return false;
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
        $length = strlen($this->string);
        if ($length % 2 !== 0) {
            return false;
        }
        $counter = 0;
        for ($i = 0; $i < $length; $i++) {
            if ($this->string[$i] == '(') {
                $counter++;
            } else {
                $counter--;
            }
            if ($counter < 0) {
                return false;
            }
        }
        if ($counter == 0) {
            return true;
        }
        return false;
    }
}
