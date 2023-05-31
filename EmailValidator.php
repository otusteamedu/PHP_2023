<?php

declare(strict_types=1);

final class EmailValidator
{
    /**
     * @param array<string> $emails
     */
    public function validateBatch(array $emails): array
    {
        return array_reduce($emails, function ($acc, $email) {
            $acc[$email] = $this->validate($email);
            return $acc;
        }, []);
    }

    public function validate(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $domain = substr(strrchr($email, "@"), 1);

        if (!checkdnsrr($domain)) {
            return false;
        }

        return true;
    }
}
