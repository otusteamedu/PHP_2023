<?php

declare(strict_types=1);

namespace Vp\App\Commands;

use DI\DependencyException;
use DI\NotFoundException;
use Vp\App\Services\Container;
use Vp\App\Services\Server;

class CommandServer implements CommandInterface
{
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function run(): void
    {
        /** @var Server $server */
        $server = Container::getInstance()->get(Server::class);
        $server->start();
    }
}
