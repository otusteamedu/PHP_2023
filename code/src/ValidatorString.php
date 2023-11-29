<?php

declare(strict_types=1);

namespace App;

class ValidatorString
{
    public static function check(string $text): void
    {
        $pattern = "/\((([^()]*|(?R))*)\)/m";
        if (!empty(preg_replace($pattern, '', $text))) {
            throw new \Exception('This text has not been verified!');
        };
    }
}
