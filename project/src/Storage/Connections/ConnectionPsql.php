<?php

declare(strict_types=1);

namespace Vp\App\Storage\Connections;

use Exception;
use PDO;
use Vp\App\Config;

class ConnectionPsql
{
    private static self|null $_instance = null;
    private static PDO $_connection;
    private function __construct()
    {
        $dbPort = Config::getInstance()->getDbPort();
        $dbname = Config::getInstance()->getDbName();
        $user = Config::getInstance()->getDbUser();
        $password = Config::getInstance()->getDbPassword();

        $dsn = "pgsql:host=postgres;port=$dbPort;dbname=$dbname;user=$user;password=$password";

        static::$_connection = new PDO($dsn);
    }

    public static function getInstance(): self
    {
        if (!static::$_instance) {
            static::$_instance = new static();
        }

        return static::$_instance;
    }

    public function getConnection(): PDO
    {
        return static::$_connection;
    }

    private function __clone()
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
