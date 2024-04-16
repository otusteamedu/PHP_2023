<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Dmitry\Hw16\App;


try {
    $app = new App();
    $app->run();
} catch (\Exception $e) {
    throw new \Exception($e->getMessage());
}
