<?php

declare(strict_types=1);

namespace Alexgaliy\EmailValidator;

use Exception;

class ValidatorMX
{
    public string $email;
    public function __construct($email)
    {
        $this->email = $email;
    }

    public function validate(): bool
    {
        // Извлечь домен из email адреса
        $domain = strrchr($this->email, "@");
        if (!$domain) {
            throw new Exception($this->email . ' не является email');
        } else {
            if (getmxrr($domain, $mxRecords)) {
                return true; // Домен имеет MX записи
            } else {
                return false; // Домен не имеет MX записей
            }
        }
    }
}
