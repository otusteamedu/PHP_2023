<?php

use Alexgaliy\ConsoleChat;

require_once 'vendor/autoload.php';


try {
    $app = new ConsoleChat\App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
