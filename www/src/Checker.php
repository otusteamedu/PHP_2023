<?php

declare(strict_types=1);


namespace Singurix\Emailscheck;

class Checker
{
    private array $emails;

    public function __construct($emails)
    {
        $this->emails = self::textToArray(trim($emails));
    }

    public function check(): array
    {
        $result = [];
        foreach ($this->emails as $email) {
            $email = str_replace("\r", "", $email);
            $result[$email] = Validator::check(trim($email));
        }
        return $result;
    }

    private function textToArray(string $emails): array
    {
        return explode(PHP_EOL, $emails);
    }
}
