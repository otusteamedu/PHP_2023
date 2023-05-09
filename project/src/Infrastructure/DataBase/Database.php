<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\DataBase;

use PDO;
use Vp\App\Infrastructure\DataBase\Contract\DatabaseInterface;

class Database implements DatabaseInterface
{
    private string $user;
    private string $password;
    private string $dbPort;
    private string $dbname;

    public function __construct(string $user, string $password, string $dbPort, string $dbname)
    {
        $this->user = $user;
        $this->password = $password;
        $this->dbPort = $dbPort;
        $this->dbname = $dbname;
    }

    public function getConnection(): PDO
    {
        $dsn = "pgsql:host=postgres;port=$this->dbPort;dbname=$this->dbname;user=$this->user;password=$this->password";
        return new PDO($dsn);
    }
}
