<?php
session_start();

use WorkingCode\Hw4\Application;

require_once '../vendor/autoload.php';

$application = new Application();
$application->run();
