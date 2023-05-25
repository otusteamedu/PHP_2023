<?php

declare(strict_types=1);

namespace App\Verify;

class Post
{

    const RESPONSE_200 = 'Все в порядке, скобки на месте';
    const RESPONSE_400 = 'Что-то не так со скобками';
    const RESPONSE_400_EMPTY = 'Пустая строка';
    const RESPONSE_405 = 'Метод не поддерживается';

    const STATUS_200 = 200;
    const STATUS_400 = 400;
    const STATUS_405 = 405;

    private string $string;

    public function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new \Exception(self::RESPONSE_405, self::STATUS_405);
        }

        $this->string = $_POST['string'];
    }

    public function checkString(): string
    {
        $string = $this->string;

        if (empty($string)) {
            throw new \Exception(self::RESPONSE_400_EMPTY, self::STATUS_400);
        }

        $stack = 0;
        for ($i = 0; $i < mb_strlen($string); $i++) {
            if ($string[$i] === '(') {
                $stack++;
            }
            if ($string[$i] === ')') {
                $stack--;
            }
            if ($stack < 0) {
                throw new \Exception(self::RESPONSE_400, self::STATUS_400);
            }
        }

        if ($stack > 0) {
            throw new \Exception(self::RESPONSE_400, self::STATUS_400);
        }

        http_response_code(self::STATUS_200);
        return self::RESPONSE_200;
    }

    /**
     * @return mixed|string
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * @param string $string
     * @return Post
     */
    public function setString(string $string): Post
    {
        $this->string = $string;
        return $this;
    }

}