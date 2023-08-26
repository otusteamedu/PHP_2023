<?php

declare(strict_types=1);

namespace Gesparo\Hw\Client;

use Gesparo\Hw\Socket\BaseSocket;

abstract class BaseClient
{
    protected BaseSocket $socket;

    public function __construct(BaseSocket $socket)
    {
        $this->socket = $socket;
    }

    abstract public function handle(): void;
}
