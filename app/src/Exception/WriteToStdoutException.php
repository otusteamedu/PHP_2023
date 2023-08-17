<?php

declare(strict_types=1);

namespace Otus\SocketChat\Exception;

use RuntimeException;

class WriteToStdoutException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('can\'t write to STDOUT');
    }
}