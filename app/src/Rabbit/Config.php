<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\Rabbit;

class Config
{
    private string $host;
    private string $port;
    private string $user;
    private string $pass;
    private string $vhost;

    /**
     * @param string $host
     * @param string $port
     * @param string $user
     * @param string $pass
     * @param string $vhost
     */
    public function __construct(string $host, string $port, string $user, string $pass, string $vhost)
    {
        $this->host = $host;
        $this->port = $port;
        $this->user = $user;
        $this->pass = $pass;
        $this->vhost = $vhost;
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
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPass(): string
    {
        return $this->pass;
    }

    /**
     * @return string
     */
    public function getVhost(): string
    {
        return $this->vhost;
    }
}
