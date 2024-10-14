<?php

declare(strict_types=1);

namespace Alexgaliy\EmailValidator;

use Exception;

class ValidatorRegExp
{
    public string $email;
    public function __construct($email)
    {
        $this->email = $email;
    }

    public function validate(): bool
    {
        // Регулярное выражение для проверки email
        $pattern = '(^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$)';

        // Проверка email с помощью preg_match
        if (preg_match($pattern, $this->email)) {
            return true; // Email валиден
        } else {
            return false; // Email невалиден
        }
    }
}
