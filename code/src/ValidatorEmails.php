<?php

declare(strict_types=1);

namespace Nautilus\Validator;

class ValidatorEmails
{

    private array $emails;

    public function __construct(array $request)
    {
        $this->emails = $request;
    }

    public function getResult(): string
    {
        return print_r($this->validation(), true);
    }
    private function validation(): array
    {
        $result = [];
        $emailsArr = $this->emails;

        foreach ($emailsArr as $arItem) {
            $result[] = [
                'Email' => $arItem, 'Валидность (Regexp)' => $this->isValidRegexp($arItem),
                'Валидность (MX)' => $this->isValidMx($arItem)
            ];
        }

        return $result;
    }

    private function isValidRegexp(string $email): string {
        if (preg_match("/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/i", $email)) {
           return $this->setStatusCode('success');
        } else {
            return $this->setStatusCode('error');
        }
    }

    private function isValidMx(string $email, string $record = 'MX'): string {
        $domain = substr(strrchr($email, "@"), 1);

        if(!checkdnsrr($domain, $record)) {
            return $this->setStatusCode('error');
        }
        return $this->setStatusCode('success');
    }

    private function setStatusCode($status): string
    {
        return ($status == 'success') ? 'success' : 'error';
    }

}