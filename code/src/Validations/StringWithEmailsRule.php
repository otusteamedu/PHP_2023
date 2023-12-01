<?php

declare(strict_types=1);

namespace GregoryKarman\EmailParser\Validations;

class StringWithEmailsRule
{
    private string $message = '';

    public function isValid(string $stringWithEmails): bool
    {
        if (empty($stringWithEmails)) {
            $this->message = 'Cтрока должна содержать email адреса разделенные символом ","';
            return false;
        }

        $emails = explode(',', $stringWithEmails);
        $noValidEmails = [];
        foreach ($emails as $email) {
            $email = trim($email);
            $isEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
            if (!$isEmail) {
                $noValidEmails[] = $email;
                continue;
            }

            $domain = substr(strrchr($email, "@"), 1);
            $isExistMxForDomain = getmxrr($domain, $mx_records, $mx_weight);
            if (!$isExistMxForDomain) {
                $noValidEmails[] = $email;
            }
        }

        if (empty($noValidEmails)) {
            return true;
        }
        $this->message = 'Строка содержит невалидные email: ' . implode(', ', $noValidEmails);
        return false;
    }

    public function message(): string
    {
        return $this->message;
    }
}
