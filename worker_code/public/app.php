<?php

include '/data/mysite.local/vendor/autoload.php';

use VKorabelnikov\Hw20\Worker\Application;

try {
    $app = new Application();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
    exit(1);
}
