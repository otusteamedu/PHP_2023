<?php

declare(strict_types=1);

namespace Yalanskiy\HomeworkRedis;

use Exception;
use RedisException;
use Symfony\Component\Console\Application;
use Yalanskiy\HomeworkRedis\Commands\ImportCommand;
use Yalanskiy\HomeworkRedis\Commands\SearchCommand;
use Yalanskiy\HomeworkRedis\Services\RedisService;

/**
 * Main App Class
 */
class App
{
    /**
     * @throws RedisException
     * @throws Exception
     */
    public function run(): void
    {
        $serviceRedis = new RedisService(REDIS_HOST, (int)REDIS_PORT);

        $application = new Application('Redis Homework (12)', '1.0');
        $application->addCommands([
            new ImportCommand($serviceRedis),
            new SearchCommand($serviceRedis),
        ]);

        $application->run();
    }
}
