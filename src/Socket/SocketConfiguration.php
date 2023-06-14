<?php

declare(strict_types=1);

namespace Otus\App\Socket;

final readonly class SocketConfiguration
{
    private array $configs;

    public function __construct(
    ) {
        $configs = parse_ini_file($_SERVER['PWD'] . '/config.ini');

        if ($configs === false) {
            throw new \InvalidArgumentException('Could not upload configuration');
        }

        $this->configs = $configs;
    }

    public function getSocketPath(): string
    {
        return array_key_exists('socket_path', $this->configs)
            ? $_SERVER['PWD'] . $this->configs['socket_path']
            : throw new \InvalidArgumentException('Config socket_path must be defined');
    }
}