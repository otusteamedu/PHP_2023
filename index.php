<?php

require_once 'vendor/autoload.php';

ob_start();

$response = (new \Iosh\Mysite\App(file_get_contents('php://input')))->run();

if ($debugInfo = ob_get_clean()) {
    $response .= PHP_EOL . 'debugInfo: ' . PHP_EOL . $debugInfo;
}

echo $response;
