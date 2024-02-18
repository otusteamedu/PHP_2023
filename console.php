<?php
declare(strict_types=1);

use WorkingCode\Hw13\Application;

require_once './vendor/autoload.php';

$application = new Application();

try {
    $application->run();
} catch (Throwable $exception) {
    printf(
        "%s %s",
        'В работе приложения возникла ошибка:',
        $exception->getMessage()
    );
}
