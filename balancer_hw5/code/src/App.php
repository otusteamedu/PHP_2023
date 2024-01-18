<?php

namespace App;

use Exception;

class App
{
    public function run()
    {
        try {
            $emails = [
                '11@sdlkfjsdl.co.uk',
                'invalid.email',
                'alisa@test.com',
                'alisa@gmail.com',
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

        $domain = substr(strrchr($email, "@"), 1);
        $res = getmxrr($domain, $mx_records, $mx_weight);
        if (false == $res || 0 == count($mx_records) || (1 == count($mx_records) && ($mx_records[0] == null  || $mx_records[0] == "0.0.0.0" ) ) ){
            //Проверка не пройдена - нормальные mx-записи не обнаружены
            echo "No MX for: ";
            return false;
        }else{
            //Проверка пройдена, живая MX-запись на домене есть, и почта на нём работает
            echo "It seems that we have qualify MX-records for: ";
        }

        return true;
    }
}
