<?php

declare(strict_types=1);

use Eevstifeev\Chat\Chat;

require dirname(__DIR__) . '/vendor/autoload.php';

try {
    $application = new Chat();
    $application->exec($argv);
} catch (Exception $e) {
}
