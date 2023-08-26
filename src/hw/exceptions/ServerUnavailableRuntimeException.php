<?php

namespace Ndybnov\Hw05\hw;

class ServerUnavailableRuntimeException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Server unavailable.', 0, null);
    }
}
