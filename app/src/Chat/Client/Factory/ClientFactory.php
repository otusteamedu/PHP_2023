<?php

declare(strict_types=1);

namespace DmitryEsaulenko\Hw15\Chat\Client\Factory;

use DmitryEsaulenko\Hw15\Chat\Client\ClientInterface;

abstract class ClientFactory
{
    public function __construct() {
    }

    abstract function createClient(): ClientInterface;
}
