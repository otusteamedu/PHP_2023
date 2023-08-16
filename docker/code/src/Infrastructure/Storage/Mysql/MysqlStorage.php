<?php

namespace IilyukDmitryi\App\Infrastructure\Storage\Mysql;

use IilyukDmitryi\App\Infrastructure\Config\ConfigApp;
use IilyukDmitryi\App\Infrastructure\Storage\Base\EventStorageInterface;
use IilyukDmitryi\App\Infrastructure\Storage\Base\StorageInterface;
use PDO;


class MysqlStorage implements StorageInterface
{
    /**
     * @var PDO
     */
    private static ?PDO $pdo = null;
    
    public function __construct()
    {
        if (is_null(static::$pdo)) {
            $settings = ConfigApp::get();
            $dbHost = $settings->getMysqlHost();
            $dbName = $settings->getMysqlDbName();
            $dbUser = $settings->getMysqlUser();
            $dbPass = $settings->getMysqlPass();
            
            static::$pdo = new PDO(
                "mysql:host={$dbHost};dbname={$dbName}",
                $dbUser,
                $dbPass,
                [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        }
    }
    
    /**
     * @return EventStorageInterface
     */
    public function getEventStorage(): EventStorageInterface
    {
        return new EventStorage(static::$pdo);
    }
}
