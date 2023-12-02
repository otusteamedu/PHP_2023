<?php

declare(strict_types=1);

namespace GregoryKarman\EmailParser\Validations;

use GregoryKarman\EmailParser\Exeptions\ValidationException;

class StringWithEmailsRule
{
    private string $message = '';

    public function isValid(string $stringWithEmails): bool
    {
        try {
            $this->isRequiredString($stringWithEmails);
            $this->isValidEmailsInString($stringWithEmails);
        } catch (ValidationException $exception) {
            $this->message = $exception->getMessage();
            return false;
        } catch (\Throwable $exception) {
            $this->message = 'Внутренняя ошибка валидацие строки с email адресами';
            return false;
        }

        return true;
    }

    /**
     * @throws ValidationException
     */
    private function isRequiredString(string $stringWithEmails): void
    {
        if (empty($stringWithEmails)) {
            throw new ValidationException('Cтрока должна содержать email адреса разделенные символом ","');
        }
    }

    /**
     * @throws ValidationException
     */
    private function isValidEmailsInString(string $stringWithEmails): void
    {
        $noValidEmails = [];
        $emails = explode(',', $stringWithEmails);
        foreach ($emails as $email) {
            $email = trim($email);
            if (!$this->isEmail($email)) {
                $noValidEmails[] = $email;
                continue;
            }

            if (!$this->isValidDomain($email)) {
                $noValidEmails[] = $email;
            }
        }

        if (!empty($noValidEmails)) {
            throw new ValidationException('Строка содержит невалидные email: ' . implode(', ', $noValidEmails));
        }
    }

    private function isEmail(string $email): bool
    {
        return boolval(filter_var($email, FILTER_VALIDATE_EMAIL));
    }

    private function isValidDomain(string $email): bool
    {
        $domain = substr(strrchr($email, "@"), 1);
        return getmxrr($domain, $mx_records, $mx_weight);
    }

    public function message(): string
    {
        return $this->message;
    }
}
