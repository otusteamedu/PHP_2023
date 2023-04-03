<?php

declare(strict_types=1);

namespace Imitronov\Hw7\Command;

use Imitronov\Hw7\Component\Config;
use Imitronov\Hw7\Exception\ConfigException;
use Imitronov\Hw7\Exception\SocketException;
use Imitronov\Hw7\UseCase\SocketServer\CreateSocketServerInput;
use Imitronov\Hw7\UseCase\SocketServer\CreateSocketServer;

final class SocketServerCommand implements Command
{
    public function __construct(
        private Config $config,
        private CreateSocketServer $createSocketServer,
    ) {
    }

    /**
     * @throws ConfigException
     * @throws SocketException
     * @throws \Exception
     */
    public function handle(): void
    {
        if (file_exists($this->config->get('host'))) {
            if (false === unlink($this->config->get('host'))) {
                throw new \Exception('Host is busy.');
            }
        }

        $input = new CreateSocketServerInput(
            $this->config->get('host'),
            (int) $this->config->get('backlog'),
            static fn($message) => fwrite(STDOUT, $message . PHP_EOL),
        );

        $this->createSocketServer->handle($input);
    }
}
