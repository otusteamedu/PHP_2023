<?php

declare(strict_types=1);

namespace Otus\SocketChat\Exception;

use RuntimeException;

class NotFoundConfigException extends RuntimeException
{
    public function __construct(string $key)
    {
        parent::__construct("config $key not found in config.ini file");
    }
}