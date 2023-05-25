<?php

declare(strict_types=1);

namespace Vp\App\Application\Builder;

use Vp\App\Application\Builder\Contract\AmqpConnectionBuilderInterface;
use Vp\App\Application\RabbitMq\Contract\AmqpConnectionInterface;
use Vp\App\Application\RabbitMq\AmqpConnection;

class AmqpConnectionBuilder implements AmqpConnectionBuilderInterface
{
    private string $host;
    private string $port;
    private string $user;
    private string $password;

    public function setHost(string $host): static
    {
        $this->host = $host;
        return $this;
    }

    public function setPort(string $port): static
    {
        $this->port = $port;
        return $this;
    }

    public function setUser(string $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): string
    {
        return $this->port;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function build(): AmqpConnectionInterface
    {
        return new AmqpConnection($this);
    }
}
