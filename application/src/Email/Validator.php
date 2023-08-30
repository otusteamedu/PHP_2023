<?php

declare(strict_types=1);

namespace Gesparo\Hw\Email;

use Gesparo\Hw\Exception\EmailException;

class Validator
{
    private FileParser $emails;
    private EmailChecker $checker;

    public function __construct(FileParser $emails, EmailChecker $checker)
    {
        $this->emails = $emails;
        $this->checker = $checker;
    }

    /**
     * @return ValidateResult[]
     * @throws EmailException
     * @throws \JsonException
     */
    public function validate(): array
    {
        $result = [];

        foreach ($this->emails->getEmails() as $email) {
            $email = trim($email);
            $result[] = new ValidateResult($email, $this->checker->check($email));
        }

        return $result;
    }
}