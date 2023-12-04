<?php

namespace App;

use Exception;

class App
{
    public function run()
    {
        try {
            $emails = [
                'user@example.com',
                'invalid.email',
                'another@test.com',
            ];

            foreach ($emails as $email) {
                if ($this->checkValidEmail($email)) {
                    echo "$email - Валидный email\n";
                } else {
                    echo "$email - Невалидный email\n";
                }
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }


    private function checkValidEmail(string $email): bool
    {
        $pattern = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/';
        if (!preg_match($pattern, $email)) {
            return false;
        }

        list(, $domain) = explode('@', $email);
        if (!checkdnsrr($domain)) {
            return false;
        }

        return true;
    }
}
