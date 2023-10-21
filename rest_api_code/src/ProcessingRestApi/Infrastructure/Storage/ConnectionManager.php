<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\Storage;

use VKorabelnikov\Hw20\ProcessingRestApi\Application\Dto\Config;
use PhpAmqpLib\Connection\AMQPStreamConnection;

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

    public function getRabbitConnection(Config $configDTO): AMQPStreamConnection
    {
        $settings = [];

        foreach ($configDTO as $settingName => $settingValue) {
            $settings[$settingName] = $settingValue;
        }

        $requiredConnectionSettings = [
            "rabbitConnectionHostName",
            "rabbitConnectionPort",
            "rabbitConnectionUser",
            "rabbitConnectionassword"
        ];

        foreach ($requiredConnectionSettings as $settingName) {
            if (empty($settings[$settingName])) {
                throw new \Exception("Не задана обязательная настройка " . $settingName . " в файле config.ini");
            }
        }

        return new AMQPStreamConnection(
            $settings['rabbitConnectionHostName'],
            $settings["rabbitConnectionPort"],
            $settings["rabbitConnectionUser"],
            $settings["rabbitConnectionassword"]
        );
    }
}
