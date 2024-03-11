<?php

namespace Shabanov\Otusphp\Connection;

interface ConnectionInterface
{
    public function getClient();

    public function close(): void;
}
