<?php
declare(strict_types=1);

require 'vendor/autoload.php';

use RedisApp\App\App;

try {
    $app = new App();
    $app->run();
} catch (Exception $exception) {

}
