<?php
declare(strict_types=1);

namespace Controllers;

use Services\EmailValidationInterface;

class EmailValidationController
{
    public function __construct(private readonly EmailValidationInterface $service)
    {}

    public function validateEmails(): void
    {
        $input = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        echo json_encode(['result' => $this->service->validateEmails($input['emails'] ?? [])], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}