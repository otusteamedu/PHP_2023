<?php

namespace app\validator;

class EmailValidator
{
    public string $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function checkIsCorrect(): bool
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return $this->checkMxRecord();
    }

    private function checkMxRecord(): bool
    {
        $domain = substr(strrchr($this->email, '@'), 1);
        $res = getmxrr($domain, $mx_records, $mx_weight);
        if (!$res || count($mx_records) == 0 || (count($mx_records) == 1 && ($mx_records[0] == null || $mx_records[0] == '0.0.0.0'))) {
            return false;
        }
        return true;
    }
}
