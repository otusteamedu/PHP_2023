<?php

declare(strict_types=1);

namespace Imitronov\Hw4\Components;

use Imitronov\Hw4\Exception\ServerException;

final class Session
{
    /**
     * @throws ServerException
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_DISABLED) {
            throw new ServerException('Sessions is disabled.');
        }

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public function get(string $key): mixed
    {
        if (!array_key_exists($key, $_SESSION)) {
            return null;
        }

        return $_SESSION[$key];
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function setIfNull(string $key, mixed $value): void
    {
        if (null === $this->get($key)) {
            $this->set($key, $value);
        }
    }

    public function increment(string $key): void
    {
        $value = (int) $this->get($key) ?? 0;
        $this->set($key, $value + 1);
    }
}
