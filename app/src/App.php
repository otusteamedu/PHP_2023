<?php

declare(strict_types=1);

namespace Imitronov\Hw7;

use DI\Container;
use DI\ContainerBuilder;
use Exception;
use Imitronov\Hw7\Command\SocketClientCommand;
use Imitronov\Hw7\Command\SocketServerCommand;
use Imitronov\Hw7\Exception\InvalidArgumentException;

final class App
{
    private Container $container;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->useAutowiring(true);
        $this->container = $containerBuilder->build();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function run(): void
    {
        $argv = $_SERVER['argv'];

        if (!isset($argv[1]) || !in_array($argv[1], ['client', 'server'], true)) {
            throw new InvalidArgumentException('Unknown command.');
        }

        switch ($argv[1]) {
            case 'server':
                $this->container->call([SocketServerCommand::class, 'handle']);
                break;
            case 'client':
                $this->container->call([SocketClientCommand::class, 'handle']);
                break;
        }
    }
}
