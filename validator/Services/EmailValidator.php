<?php

declare(strict_types=1);

namespace Rvoznyi\ComposerHello\Services;

class EmailValidator
{
    public string $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function validate(): string
    {
        $response = 'Не верный Email';
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return $response;
        }
        list($username, $domain) = explode('@', $this->email);
        if (getmxrr($domain, $mxHosts)) {
            return 'Верный Email';
        }
        return $response;
    }
}
