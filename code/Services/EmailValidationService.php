<?php
declare(strict_types=1);

namespace code\Services;

use code\Validator\EmailValidator;
use code\Validator\EmailValidatorInterface;

class EmailValidationService implements EmailValidationInterface
{
    private EmailValidatorInterface $validator;

    public function __construct()
    {
        $this->validator = new EmailValidator();
    }

    public function validateEmails(array $emails): array
    {
        return $this->validator->validate($emails);
    }
}
