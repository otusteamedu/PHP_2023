<?php
declare(strict_types=1);

namespace Services;


use Validators\EmailValidator;
use Validators\EmailValidatorInterface;

class EmailValidationService implements EmailValidationInterface
{
    public function __construct(private readonly EmailValidatorInterface $validator)
    {}

    public function validateEmails(array $emails): array
    {
        return $this->validator->validate($emails);
    }
}
