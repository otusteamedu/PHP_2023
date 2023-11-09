<?php

namespace src\Exception;

use Exception;

class NullExceptionCommand implements CommandInterface
{
    public function do(Exception $exception)
    {
    }
}
