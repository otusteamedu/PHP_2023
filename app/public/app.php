<?php

declare(strict_types=1);

use Imitronov\Hw7\App;

require_once dirname(__DIR__) . "/vendor/autoload.php";

try {
    $app = new App();
    $app->run();
} catch(Exception $e){
    echo $e->getMessage();
}
