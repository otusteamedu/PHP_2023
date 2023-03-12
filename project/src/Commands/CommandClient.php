<?php

declare(strict_types=1);

namespace Vp\App\Commands;

use DI\DependencyException;
use DI\NotFoundException;
use Vp\App\Services\Client;
use Vp\App\Services\Container;

class CommandClient implements CommandInterface
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function run(): void
    {
        $client = Container::getInstance()->get(Client::class);
        $client->work();
    }
}
