<?php

declare(strict_types=1);

namespace Twent\BracketsValidator\Http;

final class Session
{
    public function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function set(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key): ?string
    {
        return $_SESSION[$key] ?? null;
    }

    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    private function destroy(): void
    {
        session_destroy();
    }
}
