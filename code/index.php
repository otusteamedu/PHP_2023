<?php

require __DIR__ . '/vendor/autoload.php';

$config = array_merge(
    require __DIR__ . '/config/common.php',
    require __DIR__ . '/config/common-local.php',
    require __DIR__ . '/config/db.php',
    require __DIR__ . '/config/db-local.php'
);
//$application = new Application($config);
//$exitCode = $application->run();
//exit($exitCode);

// Проверяем mysql
try {
    echo "Проверяем mysql:<br>";
    $dsn = $config['dns'];
    $username = $config['username'];
    $password = $config['password'];

    $dbh = new PDO($dsn, $username, $password);
    echo "SQL. It's work!";
} catch (PDOException $exception) {
    echo $exception->getMessage();
}

function writeLogFile($string, $clear = false): void
{
    $log_file_name = __DIR__ . "/message.txt";
    $now = date("Y-m-d H:i:s");
    if ($clear == false) {
        file_put_contents($log_file_name, $now . " " . print_r($string, true) . "\r\n", FILE_APPEND);
    } else {
        file_put_contents($log_file_name, '');
        file_put_contents($log_file_name, $now . " " . print_r($string, true) . "\r\n", FILE_APPEND);
    }
}

//$data = file_get_contents('php://input');
//writeLogFile($data, true);

require __DIR__ . '/hook.php';

// phpinfo();

