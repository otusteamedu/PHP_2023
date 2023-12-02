<?php

declare(strict_types=1);

require_once('../vendor/autoload.php');

use Agrechuha\Otus\App;

try {
    $app = new App();
    $app->run($argv);
} catch (Exception $e) {
    echo $e->getMessage();
}
