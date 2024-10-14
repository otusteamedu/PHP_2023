<?php

declare(strict_types=1);

namespace Alexgaliy\EmailValidator;

use Exception;

class App
{
    public function validate(): void
    {
        $emailArray = $this->getEmailArray();
        foreach ($emailArray as $email) {
            $ValidatorMX = new ValidatorMX($email);
            $ValidatorRegExp = new ValidatorRegExp($email);
            if ($ValidatorMX->validate() && $ValidatorRegExp->validate()) {
                echo "{$email} валиден<br>";
            } else {
                echo "{$email} невалиден<br>";
            }
        }
    }

    private function getEmailArray(): array
    {
        if (empty($_POST['emails'])) {
            throw new Exception('Строка пуста');
        } else {
            $emailString = htmlspecialchars($_POST['emails']);
            $emailArray = explode(",", str_replace(' ', '', $emailString));
            return $emailArray;
        }
    }
}
