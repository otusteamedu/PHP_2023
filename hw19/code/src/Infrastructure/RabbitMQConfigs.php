<?php

declare(strict_types=1);

namespace Gkarman\Rabbitmq\Infrastructure;

class RabbitMQConfigs
{
    private readonly ?string $host;
    private readonly ?string $port;
    private readonly ?string $user;
    private readonly ?string $password;
    private readonly ?string $queue;

    public function __construct()
    {
        $configs = parse_ini_file('src/Configs/rabbitMQ.ini');
        $this->host = $configs['host'] ?? null;
        $this->port = $configs['port'] ?? null;
        $this->user = $configs['user'] ?? null;
        $this->password = $configs['password'] ?? null;
        $this->queue = $configs['queue'] ?? null;
    }

    public function getHost(): ?string
    {
        return $this->host;
    }

    public function getPort(): ?string
    {
        return $this->port;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getQueue(): ?string
    {
        return $this->queue;
    }
}
