<?php

declare(strict_types=1);

namespace src;

class Request
{
    const METHOD_POST = 'POST';
    private array $post;
    private string $method;

    public function __construct($post, $method)
    {
        $this->post = $post;
        $this->method = $method;
    }

    public function isPost(): bool
    {
        return $this->method == self::METHOD_POST;
    }

    public function getPostData(): array
    {
        return $this->post;
    }
}
