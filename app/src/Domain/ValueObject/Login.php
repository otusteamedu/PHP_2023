<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\InvalidLoginException;

class Login
{
    private string $value;

    /**
     * @param string $login
     * @throws InvalidLoginException
     */
    public function __construct(string $login)
    {
        if (strlen($login) < 10 || !preg_match('/^[A-Za-z0-9]{10,}$/', $login)) {
            throw new InvalidLoginException(
                'Login must contain Latin alphabet characters, numbers and be at least 10 characters.'
            );
        }
        $this->value = $login;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
