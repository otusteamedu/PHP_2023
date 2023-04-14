<?php

namespace Builov\Cinema;

use PDO;

class DB
{
    private static $host = DB_HOST;
    private static $db = DB_NAME;
    private static $username = DB_USERNAME;
    private static $password = DB_PASSWORD;
    public static $conn = null;

    public static function connect()
    {
        $dsn = "pgsql:host=" . self::$host . ";port=5432;dbname=" . self::$db . ";user=" . self::$username . ";password=" . self::$password;

        if (!self::$conn) {
            self::$conn = new PDO($dsn);
        }
    }
}
