<?php

namespace Gkarman\Datamaper\Commands\Classes;

use PDO;

abstract class AbstractCommand
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = $this->initPDO();
    }

    abstract public function run(): string;

    protected function initPDO(): PDO
    {
        $dirIniFile = 'src/Configs/app.ini';
        $configs = parse_ini_file($dirIniFile);

        $host = $configs['db_host'] ?? '';
        $db_name = $configs['db_name'] ?? '';
        $db_user = $configs['db_user'] ?? '';
        $db_pass = $configs['db_pass'] ?? '';

        $dsn = "pgsql:host={$host};dbname={$db_name}";

        return new PDO($dsn, $db_user, $db_pass);
    }
}
