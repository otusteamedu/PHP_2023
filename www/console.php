<?php

declare(strict_types=1);

use Symfony\Component\Console\Application;
use Yalanskiy\HomeworkRedis\Commands\ImportCommand;
use Yalanskiy\HomeworkRedis\Commands\SearchCommand;
use Yalanskiy\HomeworkRedis\Services\RedisService;

require __DIR__ . '/vendor/autoload.php';

const DATA_FILE = __DIR__ . '/data.json';
const REDIS_SEARCH_PARAMS = ['param1' => 1, 'param2' => 2];

define("REDIS_HOST", $_ENV['REDIS_HOST'] ?? '');
define("REDIS_PORT", $_ENV['REDIS_PORT'] ?? '');

try {
    $serviceRedis = new RedisService(REDIS_HOST, (int)REDIS_PORT);

    $application = new Application('Redis Homework (12)', '1.0');
    $application->addCommands([
        new ImportCommand($serviceRedis),
        new SearchCommand($serviceRedis),
    ]);

    $application->run();
} catch (Exception $exeption) {
    echo $exeption->getMessage();
}
