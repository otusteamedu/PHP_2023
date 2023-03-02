<?php

namespace Sva;

class EmailValidator
{
    public function validate(string $email): bool
    {
        $result = false;

        if($this->isValidFormat($email)) {
            $result = $this->validateMx($email);
        }

        return $result;
    }

    public function validateMx($email)
    {
        list ($name, $host) =  explode('@', $email);
        $mx = checkdnsrr($host, 'MX');
        return !empty($mx);
    }

    public function isValidFormat($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}