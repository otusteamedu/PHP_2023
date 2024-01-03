<?php

use Phinx\Console\Command\Breakpoint;
use Phinx\Console\Command\Create;
use Phinx\Console\Command\Init;
use Phinx\Console\Command\ListAliases;
use Phinx\Console\Command\Migrate;
use Phinx\Console\Command\Rollback;
use Phinx\Console\Command\SeedCreate;
use Phinx\Console\Command\SeedRun;
use Phinx\Console\Command\Status;
use Phinx\Console\Command\Test;
use Symfony\Component\Messenger\Command;
use Symfony\Component\Messenger\RoutableMessageBus;

return [
    // Phinx commands
    new Init(),
    new Create(),
    new Migrate(),
    new Rollback(),
    new Status(),
    new Breakpoint(),
    new Test(),
    new SeedCreate(),
    new SeedRun(),
    new ListAliases(),

    // Custom commands
    new Command\DebugCommand([
        container()->make(\Symfony\Component\Messenger\MessageBusInterface::class)
    ]),
    new Command\SetupTransportsCommand(container()),
    new Command\StatsCommand(container()),
    new Command\ConsumeMessagesCommand(
        new RoutableMessageBus(container(), container()->get(\Symfony\Component\Messenger\MessageBusInterface::class)),
        container(),
        container()->make(\Psr\EventDispatcher\EventDispatcherInterface::class),
        container()->get(\Psr\Log\LoggerInterface::class)
    ),
];