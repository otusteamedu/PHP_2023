<?php

namespace src\Exception;

use Exception;

class EmptyKeyForDataListExceptionCommand implements CommandInterface
{
    public function do(Exception $exception)
    {
        echo PHP_EOL;
        echo PHP_EOL;
        echo 'It is Bad! EmptyKeyForDataListExceptionCommand: ' . $exception->getMessage();
        echo PHP_EOL;
        echo PHP_EOL;
    }
}
