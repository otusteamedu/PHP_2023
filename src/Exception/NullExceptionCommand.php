<?php

namespace src\Exception;

use Exception;
use Throwable;

class NullExceptionCommand implements CommandInterface {
    public function do(Exception $exception) {
    }
}
