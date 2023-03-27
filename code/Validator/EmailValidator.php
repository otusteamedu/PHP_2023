<?php
declare(strict_types=1);

namespace code\Validator;

use code\model\Email;

class EmailValidator implements EmailValidatorInterface
{

    public function validate(array $emails): array
    {
        $result = [];

        foreach ($emails as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $result[] = new Email($email, false, 'Invalid email format');
            } else {
                $domain = explode('@', $email)[1];

                if (checkdnsrr($domain, 'MX') === false) {
                    $result[] = new Email($email, false, 'MX record not found for domain');
                } else {
                    $result[] = new Email($email, true);
                }
            }
        }

        return $result;
    }
}