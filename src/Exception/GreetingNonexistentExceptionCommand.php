<?php

namespace src\Exception;

use Exception;

class GreetingNonexistentExceptionCommand implements CommandInterface
{
    public function do(Exception $exception)
    {
        echo PHP_EOL;
        echo PHP_EOL;
        echo 'Ai-Ai-Ai !!! GreetingNonexistentExceptionCommand: ' . $exception->getMessage();
        echo PHP_EOL;
        echo PHP_EOL;
    }
}
