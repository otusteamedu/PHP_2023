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

    private array $server;
    private array $post;
    private string $string;

    public function __construct(
        array $server,
        array $post
    )
    {
        if ($server['REQUEST_METHOD'] !== 'POST') {
            throw new \Exception(self::RESPONSE_405, self::STATUS_405);
        }

        $this->server = $server;
        $this->post = $post;
        $this->string = $post['string'];
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

        return self::RESPONSE_200;
    }

    /**
     * @return array
     */
    public function getServer(): array
    {
        return $this->server;
    }

    /**
     * @param array $server
     * @return Post
     */
    public function setServer(array $server): Post
    {
        $this->server = $server;
        return $this;
    }

    /**
     * @return array
     */
    public function getPost(): array
    {
        return $this->post;
    }

    /**
     * @param array $post
     * @return Post
     */
    public function setPost(array $post): Post
    {
        $this->post = $post;
        return $this;
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