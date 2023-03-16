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

    /**
     * @throws Exception
     */
    public function checkString(): ?string
    {
        if (!isset($_POST['string'])) {
            return null;
        }
        if ($this->checkCorrect()) {
            return 'Скобки корректны.';
        }
        return null;
    }

    /**
     * @throws Exception
     */
    public function checkCorrect(): bool
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
        return true;
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
