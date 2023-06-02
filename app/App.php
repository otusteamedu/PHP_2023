<?php 
require_once __DIR__ . '/vendor/autoload.php';

ini_set('memory_limit','4096M');


try {
    $app = new nikitaglobal\controllers\App();
    $app->run();
}
catch(Exception $e){
}
