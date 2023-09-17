<?php

declare(strict_types=1);

namespace App\Validators;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use InvalidArgumentException;

final class Email
{
    private EmailValidator $emailValidator;

    public function __construct()
    {
        $this->emailValidator = new EmailValidator();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function validate(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email');
        }

        if (!$this->emailValidator->isValid($email, new DNSCheckValidation())) {
            if ($error = $this->emailValidator->getError()) {
                throw new InvalidArgumentException(
                    $error->description(),
                    $error->code()
                );
            }

            throw new InvalidArgumentException('Invalid email');
        }
    }
}
