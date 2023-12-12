<?php

declare(strict_types=1);

require_once( dirname(__FILE__) . '/vendor/autoload.php');

use Ekovalev\Otus\App\App;

try {
    $app = new App();
    $app->run($argv);
} catch (Exception $e) {
    echo $e->getMessage();
}