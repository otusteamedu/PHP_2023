<?php

namespace src\Exception;

use Exception;

class NonexistentImplementationExceptionCommand implements CommandInterface
{
    public function do(Exception $exception)
    {
        echo PHP_EOL;
        echo PHP_EOL;
        echo 'Attention! NonexistentImplementationExceptionCommand: ' . $exception->getMessage();
        echo PHP_EOL;
        echo PHP_EOL;
    }
}
