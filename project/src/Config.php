<?php

declare(strict_types=1);

namespace Vp\App;

use Exception;

final class Config
{
    private static ?Config $instance = null;
    private string $storageType;
    private string $dbUser;
    private string $dbPassword;
    private string $dbPort;
    private string $dbName;

    public static function getInstance(): Config
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function setStorageType(string $storageType): Config
    {
        $this->storageType = $storageType;
        return $this;
    }

    public function setDbUser(string $dbUser): Config
    {
        $this->dbUser = $dbUser;
        return $this;
    }

    public function setDbPassword(string $dbPassword): Config
    {
        $this->dbPassword = $dbPassword;
        return $this;
    }

    public function setDbPort(string $dbPort): Config
    {
        $this->dbPort = $dbPort;
        return $this;
    }

    public function setDbName(string $dbName): Config
    {
        $this->dbName = $dbName;
        return $this;
    }

    public function getStorageType(): string
    {
        return $this->storageType;
    }

    public function getDbUser(): string
    {
        return $this->dbUser;
    }

    public function getDbPassword(): string
    {
        return $this->dbPassword;
    }

    public function getDbPort(): string
    {
        return $this->dbPort;
    }

    public function getDbName(): string
    {
        return $this->dbName;
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
}
