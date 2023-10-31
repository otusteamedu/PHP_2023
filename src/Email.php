<?php

declare(strict_types=1);

namespace Damir\OtusHw6;

class Email
{
    private string $string;

    /**
     * @param string $string
     */
    public function __construct(string $string)
    {
        $this->string = $string;
    }

    /**
     * @return array
     */
    public function getValidEmails(): array
    {
        $emails = explode(' ', $this->string);
        $result = [];

        foreach ($emails as $email) {
            if (preg_match("/[a-z0-9\._-]+@([a-z0-9\._-]+\.[a-z0-9_-]+)/i", $email)
                && $this->checkMx($email)
            ) {
                $result[] = $email;
            }
        }

        return $result;
    }

    /**
     * @param string $email
     * @return bool
     */
    private function checkMx(string $email): bool
    {
        $domain = substr(strrchr($email, "@"), 1);

        getmxrr($domain, $mx_records, $mx_weight);

        if (empty($mx_records)) {
            return false;
        }

        return true;
    }
}