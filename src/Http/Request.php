<?php

declare(strict_types=1);

namespace Twent\BracketsValidator\Http;

final class Request
{
    public function __get(string $key): ?string
    {
        if ($this->isGet() && isset($_GET[$key])) {
            return trim(htmlspecialchars($_GET[$key]));
        }

        if ($this->isPost() && isset($_POST[$key])) {
            return trim(htmlspecialchars($_POST[$key]));
        }

        return null;
    }

    public function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    public function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}
