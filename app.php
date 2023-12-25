<?php

use WorkingCode\Hw6\Application;

require_once('./vendor/autoload.php');

set_time_limit(0);
ob_implicit_flush();

try {
    $application = new Application();
    $application->run($argv[1] ?? '');
} catch (Throwable $exception) {
    printf(
        "%s %s",
        'В работе приложения возникла ошибка:',
        $exception->getMessage()
    );
}
