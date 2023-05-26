<?php

declare(strict_types=1);

namespace YuzyukRoman\Http;

class Request
{
    public static function isPost(): bool
    {
         return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public static function getPost(): array
    {
        return $_POST;
    }
}
