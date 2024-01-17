<?php

declare(strict_types=1);

namespace App;

use PDO;
use PDOException;

class DB
{
    public static $pdo;

    public static function init()
    {
        if (!static::$pdo) {
            self::connect();
        }
        return static::$pdo;
    }

    public static function connect()
    {
        try {
            $db = 'cars_db';
            $user = 'root';
            $pass = '123456';

            $conn = new PDO("mysql:host=db;dbname=" . $db, $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            static::$pdo = $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
