<?php

declare(strict_types=1);

namespace Controllers;

use Services\EmailValidationInterface;

final readonly class EmailValidationController
{
    public function __construct(private EmailValidationInterface $service)
    {
    }

    public function validateEmails(): array
    {
        $input = json_decode(file_get_contents('php://input'), true);
        return $this->service->validateEmails($input['emails'] ?? []);
    }
}
