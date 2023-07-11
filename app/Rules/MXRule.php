<?php

namespace app\Rules;

class MXRule implements Rule
{
    public function passes($value): bool
    {
        $email = $value;

        [, $domain] = explode('@', $email);
        if (! checkdnsrr($domain)) {
            return false;
        }

        return true;
    }
}
