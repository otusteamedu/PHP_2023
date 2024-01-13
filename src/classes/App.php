<?php

namespace Klobkovsky\App;

use Exception;

class App
{
    /**
     *
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        $this->validateCommandLineArguments();
        $allArgs = $_SERVER['argv'];
        array_shift($allArgs);

        foreach ($allArgs as $email) {
            echo $email . ($this->validateEmail($email) ? ' is email' : ' is not email') . PHP_EOL;
        }
    }

    /**
     *
     * @throws Exception
     */
    private function validateCommandLineArguments(): void
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
    private function validateEmail(string $email): bool
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
