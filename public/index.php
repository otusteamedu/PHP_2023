<?php

declare(strict_types=1);

use App\App;

define("APP_PATH", dirname(__DIR__));

require_once dirname(__DIR__) . "/vendor/autoload.php";

try {
    (new App())->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
