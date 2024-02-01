<?php

declare(strict_types=1);

use Yalanskiy\HomeworkRedis\App;

require __DIR__ . '/vendor/autoload.php';

const DATA_FILE = __DIR__ . '/data.json';
const REDIS_SEARCH_PARAMS = ['param1' => 1, 'param2' => 2];

define("REDIS_HOST", $_ENV['REDIS_HOST'] ?? '');
define("REDIS_PORT", $_ENV['REDIS_PORT'] ?? '');

try {
    $app = new App();
    $app->run();
} catch (Exception $exeption) {
    echo $exeption->getMessage();
}
