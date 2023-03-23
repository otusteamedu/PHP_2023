<?php

ini_set('display_errors', 1);
require "../vendor/autoload.php";

$resultFile = \Sva\Email::validateFromFile(realpath(__DIR__ . "/../emails.txt"));
$resultInput = \Sva\Email::validateFromInput();
var_dump($resultFile, $resultInput);
