<?php

namespace App\Components;

class Session
{
    public function __construct()
    {
        session_start();
    }

    public function get(string $key): ?string
    {
        return $_SESSION[$key];
    }

    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function setIfNull(string $key, $value): void
    {
        if (null === $this->get($key)) {
            $this->set($key, $value);
        }
    }
}
