<?php

declare(strict_types=1);

namespace Vp\App;

use Exception;

final class Config
{
    private static ?Config $instance = null;
    private string $user;
    private string $password;
    private string $port;
    private string $path;
    private string $indexName;
    private string $size;

    public static function getInstance(): Config
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __clone()
    {
    }

    private function __construct()
    {
    }

    /**
     * @throws Exception
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }

    public function setUser(string $user): Config
    {
        $this->user = $user;
        return $this;
    }

    public function setPassword(string $password): Config
    {
        $this->password = $password;
        return $this;
    }

    public function setPort(string $port): Config
    {
        $this->port = $port;
        return $this;
    }

    public function setPath(string $path): Config
    {
        $this->path = $path;
        return $this;
    }

    public function setIndexName(string $name): Config
    {
        $this->indexName = $name;
        return $this;
    }

    public function setSize(string $size): Config
    {
        $this->size = $size;
        return $this;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPort(): string
    {
        return $this->port;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getIndexName(): string
    {
        return $this->indexName;
    }

    public function getSize(): string
    {
        return $this->size;
    }
}
