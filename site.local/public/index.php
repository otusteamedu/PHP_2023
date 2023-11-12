<?php

echo 'dshevchenko homework #1<br><br>';

echo 'Redis test: ';

$redis = new \Redis();
$redis->connect('redis', 6379);

if ($redis->get('testkey1')) {
    $messageText = 'found in cache';
    $value = $redis->get('testkey1'); 
} else {
    $messageText = 'not found in cache';
    $value = (string)date("Y-m-d");
    $redis->set('testkey1', $value);
}
echo "$value ($messageText)<br><br>";

echo 'Memcached test: ';

$memCache = new \Memcached();
$memCache->addServer('memcached', 11211);

if ($memCache->get('testkey2')) {
    $messageText = 'found in cache';
    $value = $memCache->get('testkey2'); 
} else {
    $messageText = 'not found in cache';
    $value = (string)date("Y-m-d");
    $memCache->set('testkey2', $value);
}
echo "$value ($messageText)<br><br>";

echo 'Mariadb test: ';

$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$username = getenv('DB_USER');
$password = getenv('DB_PWD');

try {
    $pdo = new \PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "successfully!</br>";

} catch (PDOException $e) {
    echo "failed - " . $e->getMessage();
    die();
}

echo " - test datable: ";

$query = "
    CREATE TABLE IF NOT EXISTS test (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL
    )";

try {
    $pdo->exec($query);
    echo "already exists or created successfully!";

} catch (PDOException $e) {
    echo "error - " . $e->getMessage();
    die();
}


echo "<br>  - test insert: ";

$query = 'INSERT INTO test (name) VALUES (:name)';
$statement = $pdo->prepare($query);
$statement->bindValue(":name", 'test record');
echo (string)($statement->execute());

echo "<br> - test get: <br>";

$query = 'SELECT id, name FROM test';
$statement = $pdo->prepare($query);
$statement->execute();
$statement->setFetchMode(\PDO::FETCH_ASSOC);

while ($row = $statement->fetch()) {
    echo $row['name'] . ' # ' . $row['id'] . '<br>';
}
