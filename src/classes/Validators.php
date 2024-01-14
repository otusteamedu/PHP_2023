<?php

namespace Klobkovsky\App;

class Validators
{
    /**
     *
     * @throws Exception
     */
    public static function validateCommandLineArguments(): void
    {
        if (count($_SERVER['argv']) < 2) {
            throw new Exception('Не заданы аргументы');
        }
    }

    /**
     *
     * @param string $email
     * @return bool
     */
    public static function validateEmail(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        list(,$domain) = explode('@', $email);

        if (!getmxrr($domain, $hosts)) {
            return false;
        }

        return true;
    }
}