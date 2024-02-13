<?php

use Dev\Php2023\App;

$app = new App();

try {
    $app->run();
} catch (Throwable $e) {
    echo $e->getMessage();
}
