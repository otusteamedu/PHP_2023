<?php

declare(strict_types=1);

namespace Vp\App\Application\Builder;

use Vp\App\Application\Builder\Contract\DbConnectionBuilderInterface;
use Vp\App\Infrastructure\DataBase\PgDatabase;
use Vp\App\Domain\Contract\DatabaseInterface;

class PostgresConnectionBuilder implements DbConnectionBuilderInterface
{
    private string $host;
    private string $port;
    private string $name;
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

    public function setName(string $name): static
    {
        $this->name = $name;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function build(): DatabaseInterface
    {
        return new PgDatabase($this);
    }
}
