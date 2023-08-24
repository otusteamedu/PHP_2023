<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use App\Domain\Exception\InvalidPasswordException;

class Password
{
    private string $value;

    /**
     * @param string $password
     * @throws InvalidPasswordException
     */
    public function __construct(string $password)
    {
        if (strlen($password) < 10 || !preg_match('/^[A-Za-z0-9.!@#$%^&*]{10,}$/', $password)) {
            throw new InvalidPasswordException(
                'Password must contain Latin alphabet characters, special characters numbers and 
                be at least 10 characters long.'
            );
        }
        $this->value = $password;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
