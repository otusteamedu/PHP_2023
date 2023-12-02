<?php

declare(strict_types=1);

namespace Otus\Framework\Core;

use Otus\Framework\Http\Request;

class Email
{
    /**
     * @param Request $request
     * @throws \Exception
     */
    public static function validate(Request $request): void
    {
        if (is_null($request->emails)) {
            throw new \Exception('Emails is empty!');
        }

        if (!is_array($request->emails)) {
            throw new \Exception('Emails contains invalid data format! There must be an array');
        }

        foreach ($request->emails as $email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception("{$email} is not email!");
            }

            if (empty(dns_get_record($email, DNS_MX))) {
                throw new \Exception("{$email} does not have MX records!");
            }
        }
    }
}
