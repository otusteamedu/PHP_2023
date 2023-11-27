<?php

declare(strict_types=1);

namespace Singurix\Checkinput;

class Input
{
    private array $string;
    private int $openBrackets = 0;
    private array $chars;

    public function __construct($postData)
    {
        $this->string = $postData;
    }

    public function check(): string
    {
        try {
            self::checkIsset();
            self::checkEmpty();
            self::checkBrackets();
            header('HTTP/1.1 200 OK');
            return 'Все проверки пройдены успешно';
        } catch (\Exception $e) {
            header('HTTP/1.1 400 Bad Request');
            return $e->getMessage();
        }
    }

    /**
     * @throws \Exception
     */
    private function checkIsset(): bool|\Exception
    {
        if (isset($this->string['string'])) {
            return true;
        }
        throw new \Exception('Переменная отсутствует');
    }

    /**
     * @throws \Exception
     */
    private function checkEmpty(): bool|\Exception
    {
        if (!empty($this->string['string'])) {
            return true;
        }
        throw new \Exception('Переменная пустая');
    }

    private function checkBrackets(): bool|\Exception
    {
        $brackets = array_count_values(str_split($this->string['string']));
        if (isset($brackets['(']) && isset($brackets[')'])
            && $brackets['('] == $brackets[')']
        ) {
            $this->chars = str_split($this->string['string']);
            if (self::checkPosition()) {
                return true;
            }
        }

        throw new \Exception(
            'Количество скобок не совпадает или неверная последовательность'
        );
    }

    private function checkPosition(): bool
    {
        if (count($this->chars) == 0) {
            return true;
        }
        $firstChar = array_shift($this->chars);
        if ($firstChar == '(') {
            $this->openBrackets++;
            return self::checkPosition();
        } elseif ($firstChar == ')') {
            if ($this->openBrackets == 0) {
                return false;
            } else {
                $this->openBrackets--;
                return self::checkPosition();
            }
        }
        return false;
    }
}
