<?php

declare(strict_types= 1);

require_once 'vendor/autoload.php';

use Dshevchenko\Brownchat\App;

try {
    $app = new App();
    $app->run($argv);
}
catch(Exception $e){
    fwrite(STDOUT, $e->getMessage());
}
