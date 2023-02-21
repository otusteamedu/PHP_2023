<?php

declare(strict_types=1);

namespace Twent\EmailValidator;

use Generator;
use Twent\EmailValidator\Exceptions\EmptyEmailString;
use Twent\EmailValidator\Exceptions\MxRecordNotExists;
use Twent\EmailValidator\Exceptions\NotValidEmailString;

final class EmailValidator
{
    /**
     * @param array<string> $emails
     */
    public function __construct(
        private readonly array $emails,
    ) {
    }

    /**
     * @throws EmptyEmailString
     * @throws NotValidEmailString
     * @throws MxRecordNotExists
     */
    public function handle(): void
    {
        foreach ($this->lazyLoadEmails() as $email) {
            $this->validate($email);
        }
    }

    private function lazyLoadEmails(): Generator
    {
        // Remove duplicates
        $emails = array_keys(array_flip($this->emails));

        foreach ($emails as $email) {
            yield trim(htmlspecialchars($email));
        }
    }

    private function checkSyntax(string $email): bool
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    private function checkMxRecord(string $email): bool
    {
        [$username, $domain] = explode('@', $email);

        if (! checkdnsrr($domain)) {
            return false;
        }

        return true;
    }

    /**
     * @throws EmptyEmailString
     * @throws NotValidEmailString
     * @throws MxRecordNotExists
     */
    private function validate(string $email): void
    {
        if (! $email) {
            throw new EmptyEmailString();
        }

        if (! $this->checkSyntax($email)) {
            throw new NotValidEmailString($email);
        }

        if (! $this->checkMxRecord($email)) {
            throw new MxRecordNotExists($email);
        }
    }
}
