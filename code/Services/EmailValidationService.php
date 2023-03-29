<?php
declare(strict_types=1);

namespace Services;

use Validators\EmailValidatorInterface;

final readonly class EmailValidationService implements EmailValidationInterface
{
    public function __construct(private EmailValidatorInterface $validator)
    {}

    public function validateEmails(array $emails): array
    {
        return $this->validator->validate($emails);
    }
}
