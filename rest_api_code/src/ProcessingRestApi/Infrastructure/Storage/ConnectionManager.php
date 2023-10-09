<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Storage;

use VKorabelnikov\Hw16\MusicStreaming\Application\Dto\Config;

class ConnectionManager
{
    protected Config $configDTO;

    public function __construct(Config $configDTO)
    {
        $this->configDTO = $configDTO;
    }
    public function getPdo(): \PDO
    {
        $connectionMethod = "get" . $this->configDTO->DBMSName . "Pdo";
        return $this->$connectionMethod();
    }

    protected function getPostgresPdo(): \PDO
    {
        $dsn = "pgsql:";
        $dsn .= "host=" . $this->configDTO->connectionDbHost . ";";
        $dsn .= "port=" . $this->configDTO->connectionDbPort . ";";
        $dsn .= "dbname=" . $this->configDTO->connectionDbName . ";";

        return new \PDO(
            $dsn,
            $this->configDTO->connectionDbUser,
            $this->configDTO->connectionDbPassword
        );
    }
}
