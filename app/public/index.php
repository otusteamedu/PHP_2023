<?php


try {
    phpinfo();
//    $app = new App();
//    $app->run();
} catch (\Exception $e) {
    echo "Error " . $e->getMessage();
    exit(1);
}