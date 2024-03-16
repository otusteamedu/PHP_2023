<?php

declare(strict_types=1);

namespace Yalanskiy\SearchApp;

use Exception;
use Yalanskiy\SearchApp\Domain\Repository\DataRepositoryInterface;
use Symfony\Component\Console\Application as ConsoleApplication;
use Yalanskiy\SearchApp\Infrastructure\Command\FindCommand;
use Yalanskiy\SearchApp\Infrastructure\Command\LoadCommand;

/**
 * Main Application class
 */
class Application {
    private const DB_PROVIDER = 'Yalanskiy\SearchApp\Infrastructure\Db\ElasticDatabaseProvider';
    private DataRepositoryInterface $dbConnection;
    
    public function __construct()
    {
        $this->dbConnection = new (self::DB_PROVIDER)();
    }
    
    /**
     * @throws Exception
     */
    public function run(): void
    {
        $console = new ConsoleApplication('ElasticSearch New (15)', '1.0');
        $console->addCommands([
            new LoadCommand($this->dbConnection),
            new FindCommand($this->dbConnection),
        ]);
        $console->run();
    }
}