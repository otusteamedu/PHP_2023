<?php

namespace Nalofree\Hw5;

class EmailChecker
{
    private string $string;

    public function __construct($string)
    {
        $this->string = (string)$string;
    }

    private function getEmails($string): array|bool
    {
        $emails = preg_split('/\s+|\,\s?/', $string);
        // Из строки надо получить адреса, они могут быть через пробел или через запятую.
        return array_diff($emails, array(''));
    }

    public function check(): array
    {
        $pattern = "/[a-z0-9\._-]+@([a-z0-9\._-]+\.[a-z0-9_-]+)/i";
        $string = $this->string;
        $checked_emails = [];
        $emails = $this->getEmails($string);

        foreach ($emails as $email) {
            if (preg_match($pattern, $email, $matches)) {
                $checked_emails[$matches[0]] = $this->checkMxRecord($matches[1]) ? "valid" : "invalid";
            }
        }
        return $checked_emails;
    }

    private function checkMxRecord($domain): bool
    {
        getmxrr($domain, $mx_records, $mx_weight);
        if (empty($mx_records)) {
            return false;
        } else {
            return true;
        }
    }
}
