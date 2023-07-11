<?php

namespace app\Rules;

class EmailRule implements Rule
{
    public function passes($value): bool
    {
        $pattern = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";

        return preg_match($pattern, $value) === 1;
    }
}
