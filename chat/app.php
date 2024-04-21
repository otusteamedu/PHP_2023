<?php

require __DIR__ . '/vendor/autoload.php';

try {
    $app = new \Anna\Chat\App();
    $app->run();
} catch (Exception $e)
{
    echo $e->getMessage();
}