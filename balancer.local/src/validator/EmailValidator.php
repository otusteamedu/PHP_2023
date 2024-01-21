<?php

namespace VladimirPetrov\EmailValidator\validator;

class EmailValidator
{

    /**
     * @param array $emails
     * @return bool
     */
    public function validate(array $emails): bool
    {
        foreach ($emails as $email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
        }

        foreach ($emails as $email) {
            $hostname = explode('@', $email)[1];

            if (!getmxrr($hostname, $hosts)) {
                return false;
            }
        }

        return true;
    }
}
