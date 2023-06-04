<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\DataBase;

use PDO;
use Vp\App\Application\Builder\Contract\DbConnectionBuilderInterface;
use Vp\App\Domain\Contract\DatabaseInterface;

class PgDatabase implements DatabaseInterface
{
    private string $user;
    private string $password;
    private string $dbPort;
    private string $dbHost;
    private string $dbname;

    public function __construct(DbConnectionBuilderInterface $dbConnectionBuilder)
    {
        $this->user = $dbConnectionBuilder->getUser();
        $this->password = $dbConnectionBuilder->getPassword();
        $this->dbPort = $dbConnectionBuilder->getPort();
        $this->dbHost = $dbConnectionBuilder->getHost();
        $this->dbname = $dbConnectionBuilder->getName();
    }

    public function getConnection(): PDO
    {
        $dsn = "pgsql:host=$this->dbHost;port=$this->dbPort;dbname=$this->dbname;user=$this->user;password=$this->password";
        return new PDO($dsn);
    }
}
