<?php
$serverName = $_SERVER['HOSTNAME'];
echo "This request was processed by PHP in container: $serverName\n";
$serverName = $_SERVER['SERVER_ADDR'];
echo "This request was processed by PHP in container: $serverName\n";

$containerId = $_SERVER['SERVER_NAME'];
echo "This request was processed by PHP in container: $containerId\n";


echo "This request was processed by PHP in container: " . gethostname();


$logFile = 'request.log';
$currentDate = date('Y-m-d H:i:s');
$hostname = gethostname();
file_put_contents($logFile, "[$currentDate] Request handled by: $hostname\n", FILE_APPEND);
