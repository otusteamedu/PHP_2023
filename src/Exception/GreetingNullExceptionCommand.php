<?php

namespace src\Exception;

use Exception;

class GreetingNullExceptionCommand implements CommandInterface
{
    public function do(Exception $exception)
    {
        echo PHP_EOL;
        echo PHP_EOL;
        echo 'Oi-Oi-Oi !!! GreetingNullExceptionCommand: ' . $exception->getMessage();
        echo PHP_EOL;
        echo PHP_EOL;
    }
}
