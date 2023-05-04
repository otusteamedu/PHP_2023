<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test services docker</title>
</head>
<body>
<pre>
<?php
$formatError = function ($text)
{
    return "<span style='color: red'>{$text}</span>";
};
$formatGood = function ($text)
{
    return "<span style='color: green'>{$text}</span>";
};
$formatHead = function ($text)
{
    return "<span style='color: black; font-weight: bolder'>{$text}</span>";
};

$dbName = $_ENV["DB_NAME"];
$tableName = $_ENV["DB_NAME"];
$username = $_ENV["DB_USER"];
$password = $_ENV["DB_PASSWORD"];

echo $formatHead("---=== TEST postgres ===---".PHP_EOL);
try {
    $dsn = "pgsql:host=postgres;port=5432;dbname=$dbName";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "CREATE TABLE IF NOT EXISTS $tableName (
            id SERIAL PRIMARY KEY,
            name VARCHAR(255),
            value INTEGER
        )";
    
    $pdo->exec($sql);
    echo $formatGood("Table created successfully.".PHP_EOL);
    $resQuery = $pdo->query(
        "select table_name, column_name from information_schema.columns where table_name='$tableName'"
    );
    
    $insert_query = $pdo->prepare("INSERT INTO {$tableName} (id,name,value) VALUES (?, ?, ?)");
    $insert_query->execute([time(), 'test', 1]);
    
    $resQuery = $pdo->query("select * from {$tableName} ORDER BY id DESC LIMIT 1 ");
    while ($row = $resQuery->fetch(PDO::FETCH_ASSOC)) {
        echo '<pre>'.print_r($row, 1).'</pre>';
    }
    echo $formatGood("Postgres work.".PHP_EOL);
} catch (Throwable $e) {
    echo $formatError("Error postgres creating table: ".$e->getMessage().PHP_EOL);
}

echo $formatHead(PHP_EOL."---=== TEST mysql ===---".PHP_EOL);
try {
    $dsn = "mysql:host=mysql;port=3306;dbname=$dbName";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "CREATE TABLE IF NOT EXISTS $tableName (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255),
            value INT
        )";
    $pdo->exec($sql);
    echo $formatGood("Table created successfully.".PHP_EOL);
    $insert_query = $pdo->prepare("INSERT INTO {$tableName} (`id`,`name`,`value`) VALUES (?, ?, ?)");
    $insert_query->execute([null, 'test', 1]);
    
    $resQuery = $pdo->query("select * from {$tableName} ORDER BY `id` DESC LIMIT 1 ");
    while ($row = $resQuery->fetch(PDO::FETCH_ASSOC)) {
        echo '<pre>'.print_r($row, 1).'</pre>';
    }
    echo $formatGood("Mysql work.".PHP_EOL);
} catch (Throwable $e) {
    echo $formatError("Error mysql creating table: ".$e->getMessage());
}

echo $formatHead(PHP_EOL."---=== TEST memcached ===---".PHP_EOL);
try {
    $memcached = new Memcached();
    $memcached->addServer('memcached', 11211);
    $memcached->set("testMemcachedKey", "Test Memcached value time = ".time());
    echo $formatGood($memcached->get("testMemcachedKey").PHP_EOL);
} catch (Throwable $e) {
    echo $formatError("Error test memcached: ".$e->getMessage());
}

echo $formatHead(PHP_EOL."---=== TEST redis ===---".PHP_EOL);
try {
    $redis = new Redis();
    $redis->connect('redis');
    $redis->set('testKey', 'Test Redis  time = '.time());
    $value = $redis->get('testKey');
    echo $formatGood($value.PHP_EOL);
} catch (RedisException $e) {
    echo $formatError("Error test redis: ".$e->getMessage());
}

echo $formatHead(PHP_EOL."---=== TEST composer ===---".PHP_EOL);
try {
    exec('composer -V', $output,$resCode);
    if($resCode){
        throw new Exception("composer not install");
    }
    echo $formatGood("Composer version is: ".implode(PHP_EOL, $output));
} catch (Throwable $e) {
    echo $formatError("Error test Composer: ".$e->getMessage());
}
?>
</pre>
</body>
</html>