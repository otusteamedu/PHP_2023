<?php

declare(strict_types=1);

namespace App\Validate;

use EmailValidator\EmailValidator;

class EmailValidatorProxy
{
    private const CONFIG = ['checkMxRecords' => true];

    private const PATTERN = "/^[a-z0-9!#$%&'*+\\/=?^_`{|}~-]+(?:\\.[a-z0-9!#$%&'*+\\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/";

    private EmailValidator $validator;

    public function __construct()
    {
        $this->validator = new EmailValidator(self::CONFIG);
    }

    public function validate(string $email): bool
    {
        return preg_match(self::PATTERN, $email) && $this->validator->validate($email);
    }

    public function getError(): string
    {
        return $this->validator->getErrorReason();
    }
}
