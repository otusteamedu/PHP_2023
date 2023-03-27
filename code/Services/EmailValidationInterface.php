<?php
declare(strict_types=1);

namespace code\Services;

interface EmailValidationInterface
{
    public function validateEmails(array $emails): array;
}
