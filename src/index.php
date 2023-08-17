<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$service = new \ArtemCherepanov\OtusComposer\Application\StringService();
$command = new \ArtemCherepanov\OtusComposer\Infrastructure\StringCommand($service);
$command->execute();
