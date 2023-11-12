<?php

declare(strict_types=1);

namespace User\Php2023\Infrastructure\Queue\RabbitMQ;

final class RabbitMQConnection
{
    private string $host;
    private string $port;
    private string $username;
    private string $password;
    private string $connectionString;

    public function __construct(string $host, string $port, string $username, string $password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->connectionString = "amqp://$username:$password@$host:$port";
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getPort(): string
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getConnectionString(): string
    {
        return $this->connectionString;
    }
}
