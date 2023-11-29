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
            $this->checkIsset()
                ->checkEmpty()
                ->checkBrackets();
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
    private function checkIsset(): Input|\Exception
    {
        if (isset($this->string['string'])) {
            return $this;
        }
        throw new \Exception('Переменная отсутствует');
    }

    /**
     * @throws \Exception
     */
    private function checkEmpty(): Input|\Exception
    {
        if (!empty($this->string['string'])) {
            return $this;
        }
        throw new \Exception('Переменная пустая');
    }

    private function checkBrackets(): bool|\Exception
    {
        $brackets = array_count_values(str_split($this->string['string']));
        if (
            isset($brackets['(']) && isset($brackets[')'])
            && $brackets['('] == $brackets[')']
        ) {
            $this->chars = str_split($this->string['string']);
            if ($this->checkPosition()) {
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
            return $this->checkPosition();
        } elseif ($firstChar == ')') {
            if ($this->openBrackets == 0) {
                return false;
            } else {
                $this->openBrackets--;
                return $this->checkPosition();
            }
        }
        return false;
    }
}
