<?php

namespace Myklon\Hw5\Services;

class RequestValidator
{
    public static function validate($parameter)
    {
        if (!isset($_POST[$parameter])) {
            throw new \Exception("The '$parameter' parameter was not found.");
        }

        if (empty($_POST[$parameter])) {
            throw new \Exception("The '$parameter' parameter is empty.");
        }
    }
}
