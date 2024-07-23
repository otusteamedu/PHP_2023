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

echo "<br><br>";
echo "Привет, Otus!<br>" . date("Y-m-d H:i:s") . "<br><br>";

echo "А тут изменился код";

phpinfo();

