<?php

declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOException;
use RuntimeException;

class Database implements DatabaseInterface
{
    public function connect(): PDO
    {
        if (!$config = parse_ini_file(APP_PATH . '/.env')) {
            throw new RuntimeException('Не найден файл конфига');
        }

        if (!isset($config['DRIVER']) || !isset($config['HOST']) || !isset($config['PORT']) || !isset($config['DB']) || !isset($config['USER']) || !isset($config['PASSWORD'])) {
            throw new RuntimeException('Не найдены переменные конфигурации');
        }

        $driver = $config['DRIVER'];
        $host = $config['HOST'];
        $port = $config['PORT'];
        $db = $config['DB'];
        $user = $config['USER'];
        $password = $config['PASSWORD'];

        $dsn = "$driver:host=$host;port=$port;dbname=$db;";

        try {
            return new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        } catch (PDOException $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }
}
