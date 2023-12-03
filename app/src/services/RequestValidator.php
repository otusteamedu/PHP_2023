<?php

namespace Myklon\Hw4\Services;

class RequestValidator
{
    public static function validate()
    {
        if (!isset($_POST['string'])) {
            throw new \Exception("The 'string' parameter was not found.");
        }

        if (empty($_POST['string'])) {
            throw new \Exception("The 'string' parameter is empty.");
        }
    }
}