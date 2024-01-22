<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Db;

use Http\Client\Exception;
use PDO;

class PgClient implements DbManager
{
    private static ?self $instance = null;
    private PDO $client;
    private function __construct()
    {
        $dsn = 'pgsql:host='.$_ENV['POSTGRES_HOST'].';port=5432;dbname='.$_ENV['POSTGRES_DB'];
        $this->client = new PDO($dsn, $_ENV['POSTGRES_USER'], $_ENV['POSTGRES_PASSWORD']);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * @throws \Exception
     */
    public function getClient(): PDO
    {
        try {
            return $this->client;
        } catch(\Exception $e) {
            throw new \Exception('Error connect to Db Postgres' . $e->getMessage());
        }
    }
}
