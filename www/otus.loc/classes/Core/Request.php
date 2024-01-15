<?php

namespace Sherweb\Core;

class Request
{
    /**
     * @return bool
     */
    public static function isPost(): bool
    {
        return $_SERVER["REQUEST_METHOD"] == "POST";
    }

    public static function setStatus(string $status): void
    {
        header($status);
    }
}