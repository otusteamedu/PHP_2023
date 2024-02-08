<?php

use WorkingCode\Hw11\Application;
use WorkingCode\Hw11\Command\CreateIndexWithData;
use WorkingCode\Hw11\Command\SearchCommand;

require_once './vendor/autoload.php';

try {
    $options = getopt('', array_merge(CreateIndexWithData::OPTIONS, SearchCommand::OPTIONS)) ?: [];

    $application = new Application();
    $application->run($options);
} catch (Throwable $exception) {
    printf(
        "%s %s",
        'В работе приложения возникла ошибка:',
        $exception->getMessage()
    );
}
