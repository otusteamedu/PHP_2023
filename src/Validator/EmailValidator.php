<?php

namespace WorkingCode\Hw5\Validator;

class EmailValidator
{
    public function validate(string $email): bool
    {
        return (bool)filter_var($email, FILTER_VALIDATE_EMAIL)
            && $this->checkMxRecord($email);
    }

    private function checkMxRecord(string $email): bool
    {
        $hostname = explode('@',$email, 2)[1];

        return getmxrr($hostname, $hosts);
    }
}
