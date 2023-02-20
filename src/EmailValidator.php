<?php

declare(strict_types=1);

namespace Twent\EmailValidator;

use Twent\EmailValidator\Exceptions\EmptyEmailString;
use Twent\EmailValidator\Exceptions\MxRecordNotExists;
use Twent\EmailValidator\Exceptions\NotValidEmailString;

final class EmailValidator
{
    /**
     * @throws EmptyEmailString
     * @throws NotValidEmailString
     * @throws MxRecordNotExists
     */
    public function handle(string ...$emails): void
    {
        foreach ($emails as $email) {
            $email = trim(htmlspecialchars($email));

            if (! $email) {
                throw new EmptyEmailString();
            }

            if (! $this->checkSyntax($email)) {
                throw new NotValidEmailString($email);
            }

            [$username, $domain] = explode('@', $email);

            if (! $this->checkMxRecord($domain)) {
                throw new MxRecordNotExists($domain);
            }
        }
    }

    private function checkSyntax(string $email): bool
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    private function checkMxRecord(string $domain): bool
    {
        if (! checkdnsrr($domain)) {
            return false;
        }

        return true;
    }
}
