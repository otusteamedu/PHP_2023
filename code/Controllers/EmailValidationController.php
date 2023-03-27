<?php
declare(strict_types=1);

namespace code\Controllers;


use code\Services\EmailValidationInterface;

class EmailValidationController
{
    private EmailValidationInterface $service;

    public function __construct(EmailValidationInterface $service)
    {
        $this->service = $service;
    }

    public function validateEmails(array $emails): array
    {
        return $this->service->validateEmails($emails);
    }
}