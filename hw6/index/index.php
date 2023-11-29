<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

$line = readline("Process: ");
readline_add_history($line);
$process = readline_list_history()[0] ;

$app = new Elena\Hw6\App();
$app->run($process);
