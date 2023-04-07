<?php

namespace Builov\Cinema;

use PDO;
class DB
{
    private static $host = 'postgres_2';
    private static $db = 'test_db';
    private static $username = 'root';
    private static $password = 'root';
    public static $conn = null;

//    public static function init()
//    {
//        self::$dsn = "pgsql:host=" . self::$host . ";port=5432;dbname=" . self::$db . ";user=" . self::$username . ";password=" . self::$password;
//    }
    public static function connect()
    {
        $dsn = "pgsql:host=" . self::$host . ";port=5432;dbname=" . self::$db . ";user=" . self::$username . ";password=" . self::$password;

        if (!self::$conn) {
            self::$conn = new PDO($dsn);
        }
    }
}