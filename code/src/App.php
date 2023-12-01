<?php

declare(strict_types=1);

namespace GregoryKarman\EmailParser;

use GregoryKarman\EmailParser\Validations\StringWithEmailsRule;

class App
{
    public function run(): string
    {
        $emails = $_POST['emails'] ?? '';

        $rule = new StringWithEmailsRule();
        $isValidEmailsInString = $rule->isValid($emails);

        if ($isValidEmailsInString) {
            return 'строка содержит валидные email адреса';
        }

        return $rule->message();
    }
}
