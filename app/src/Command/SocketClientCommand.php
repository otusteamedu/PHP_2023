<?php

declare(strict_types=1);

namespace Imitronov\Hw7\Command;

use Imitronov\Hw7\Component\Config;
use Imitronov\Hw7\Exception\ConfigException;
use Imitronov\Hw7\Exception\SocketException;
use Imitronov\Hw7\UseCase\SocketClient\CreateSocketClientInput;
use Imitronov\Hw7\UseCase\SocketClient\CreateSocketClient;

final class SocketClientCommand implements Command
{
    public function __construct(
        private Config $config,
        private CreateSocketClient $createSocketClient,
    ) {
    }

    /**
     * @throws ConfigException
     * @throws SocketException
     */
    public function handle(): void
    {
        $input = new CreateSocketClientInput(
            $this->config->get('host'),
            static fn () => trim(fgets(STDIN)),
            static fn ($message) => fwrite(STDOUT, $message . PHP_EOL),
        );

        $this->createSocketClient->handle($input);
    }
}
