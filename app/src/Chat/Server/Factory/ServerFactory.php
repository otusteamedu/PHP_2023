<?php

declare(strict_types=1);

namespace DmitryEsaulenko\Hw15\Chat\Server\Factory;

use DmitryEsaulenko\Hw15\Chat\Server\ServerInterface;

abstract class ServerFactory
{
    public function __construct()
    {
    }

    abstract public function createServer(): ServerInterface;
}
