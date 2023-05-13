<?php

namespace app;

class EmailChecker
{
    public function process(string $filepath): void
    {

        $handle = fopen($filepath, "r");
        if ($handle) {
            while (($email = fgets($handle)) !== false) {
                if ($this->validateEmail($email)) {
                    $status = 'OK';
                } else {
                    $status = 'WRONG';
                }
                echo $email . ' - ' . $status . '<br>';
            }

            fclose($handle);
        }
    }

    public function validateEmail(string $email): bool
    {
        // првоеряем регулярным выражением
        $pattern = '/^[\w\-\.]+@([\w\-]+\.)+[\w]{2,4}$/';
        preg_match($pattern, $email, $matches);
        if (!$matches[0]) {
            return false;
        }

        // проверяем mx-запись
        $hosts = [];
        $hostname = explode('@', $email);
        $hostname = trim($hostname[1]);
        getmxrr($hostname, $hosts);
        if (count($hosts) == 0) {
            return false;
        }

        return true;
    }
}
