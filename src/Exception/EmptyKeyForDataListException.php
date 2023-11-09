<?php

namespace src\Exception;

use Exception;
use Throwable;

class EmptyKeyForDataListException extends Exception {
    public function __construct($message, $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
