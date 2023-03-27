<?php
declare(strict_types=1);

namespace Models;

class Email
{
    public function __construct(public string $email, public bool $isValid, public string $errorMessage = '')
    {}
}