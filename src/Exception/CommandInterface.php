<?php

namespace src\Exception;

use Exception;

interface CommandInterface
{
    public function do(Exception $exception);
}
