<?php
declare(strict_types=1);

namespace code\model;

class Email
{
    public $email;
    public $isValid;
    public $errorMessage;

    public function __construct(string $email, bool $isValid, string $errorMessage = '')
    {
        $this->email = $email;
        $this->isValid = $isValid;
        $this->errorMessage = $errorMessage;
    }
}