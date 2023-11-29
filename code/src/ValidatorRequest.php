<?php

declare(strict_types=1);

namespace App;

class ValidatorRequest
{
    public static function check(): void
    {
        if (empty($_POST['text'])) {
            throw new \Exception("There is no text to check");
        }

        if (is_numeric($_POST['text'])) {
            throw new \Exception("This text is numeric");
        }

        if (!is_string($_POST['text'])) {
            throw new \Exception("This text is not a string");
        }
    }
}
