<?php

declare(strict_types=1);

namespace Artyom\Php2023\validator;

class EmailValidator
{
    /**
     * @param array $emails
     *
     * @return array
     */
    public function validate(array $emails): array
    {
        foreach ($emails as $key => $email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                unset($emails[$key]);
            }
        }

        foreach ($emails as $key => $email) {
            $hostname = explode('@', $email)[1];

            if (!getmxrr($hostname, $hosts)) {
                unset($emails[$key]);
            }
        }

        return $emails;
    }
}
