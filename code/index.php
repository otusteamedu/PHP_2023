<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <title>OTUS homework #1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <h4>Проверка работы с Redis</h4>
    <?php
    $redis = new Redis();

    try {
        $redis->connect('redis');
        $redis->set('redis_key', 'Redis value for test');
        $value = $redis->get('redis_key');
        echo '<div class="text-success">Коннект с Redis прошел успешно</div>';
        echo "<p>По ключу 'redis_key' достали значение '{$value}'</p>";
    } catch (Exception $e) {
        echo '<div class="text-danger">Ошибка соединения с Redis' . $e->getMessage() . '</div>';
    }
    ?>
</div>

<div class="container">
    <h4>Проверка работы с Memcached</h4>
    <?php
    $memcached = new Memcached();

    try {
        $memcached->addServer('memcached', 11211);
        $memcached->set('memcached_key', 'Memcached value for test');
        $value = $memcached->get('memcached_key');
        echo '<div class="text-success">Коннект с Memcached прошел успешно</div>';
        echo "<p>По ключу 'memcached_key' достали значение '{$value}'</p>";
    } catch (Exception $e) {
        echo '<div class="text-danger">Ошибка соединения с Memcached' . $e->getMessage() . '</div>';
    }
    ?>
</div>

<div class="container">
    <h4>Проверка работы с MySQL</h4>
    <?php
    $pass = getenv('DB_ROOT_PASSWORD');
    $mydb = getenv('DB_NAME');

    $dsn = "mysql:dbname=$mydb;host=db";

    try {
        $pdo = new PDO($dsn, 'root', getenv('DB_ROOT_PASSWORD'));
        $query = 'CREATE TABLE IF NOT EXISTS test (
                         id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                         text VARCHAR(255) NOT NULL,    
                         PRIMARY KEY(id)
                        );';
        $result = $pdo->exec($query);
        echo '<div class="text-success">Создание таблицы прошло успешно</div>';
        $query = "INSERT INTO `test` (`text`) VALUES (:text);";
        $params = [
            ':text' => 'Test value'
        ];
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $rows = $pdo->query("SELECT * FROM test;")->fetchAll(PDO::FETCH_ASSOC);
        echo '<table class="table table-bordered">';
        echo "<thead><tr><th>ID</th><th>Text</th></tr></thead>";
        foreach ($rows as $row) {
            echo "<tr><td>{$row['id']}</td><td>{$row['text']}</td></tr>";
        }
        echo '</table>';
    } catch (PDOException $e) {
        echo '<div class="text-danger">Ошибка соединения с MySQL' . $e->getMessage() . '</div>';
    }

    ?>
</div>

<div class="container">
    <h4>Проверка работы PHP</h4>
    <?php
    phpinfo();
    ?>
</div>

</body>
</html>


