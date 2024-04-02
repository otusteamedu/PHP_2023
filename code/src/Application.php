<?php

declare(strict_types=1);

namespace Dmatrenin\Bracket;

use Exception;

class Application
{
    public static function run()
    {
        try {
            http_response_code(200);
            echo Validator::validate($_POST['string']);
        } catch (Exception $e) {
            http_response_code($e->getCode());
            echo $e->getMessage();
        }
    }
}
