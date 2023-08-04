<?php

namespace src\domain;

class StorageDTO
{
    private string $host;
    private int $port;
    private string $keyStore;
    private string $messageStore;
    private int $expireSec;

    /**
     * @param string $host
     * @param int $port
     * @param string $keyStore
     * @param string $messageStore
     * @param int $expireSec
     */
    public function __construct(string $host, int $port, string $keyStore, string $messageStore, int $expireSec)
    {
        $this->host = $host;
        $this->port = $port;
        $this->keyStore = $keyStore;
        $this->messageStore = $messageStore;
        $this->expireSec = $expireSec;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getKeyStore(): string
    {
        return $this->keyStore;
    }

    public function getMessageStore(): string
    {
        return $this->messageStore;
    }

    public function getExpireSec(): int
    {
        return $this->expireSec;
    }
}
