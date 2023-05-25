<?php

declare(strict_types=1);

namespace Iosh\EmailValidator;

use Exception;

class Email
{
    use Validator;

    private string $email;

    /**
     * @param string $email
     * @throws Exception
     */
    public function __construct(string $email)
    {
        $this->email = trim($email);
        if (!$this->validate()) {
            throw new Exception('Incorrect email');
        }
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
