<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HomeWork 1</title>
</head>
<body>
    <div>
        <?php

        $br = '<br>';
        echo "Проверка соединения с postgres:" . $br;
        echo "Создание таблицы test и вывод списка table-column:" . $br;

        $dbname = $_ENV["DB_DATABASE"];
        $user = $_ENV["DB_USERNAME"];
        $password = $_ENV["DB_PASSWORD"];

        $dsn = "pgsql:host=postgres;port=5432;dbname=$dbname;user=$user;password=$password";

        try {
            $conn = new PDO($dsn);

            $sql = "CREATE TABLE IF NOT EXISTS test (
                        id serial PRIMARY KEY,
                        number character varying(20) NOT NULL UNIQUE,
                        name character varying(20) NOT NULL
                        )";
            $conn->exec($sql);

            $res = $conn->query("select table_name, column_name from information_schema.columns where table_schema='public'");

            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                echo($row["table_name"].'-'.$row["column_name"] . $br);
            }

        } catch (PDOException $e){
            echo $e->getMessage();
        }

        echo "Проверка соединения с redis:" . $br;
        echo "Добавление в redis записи 'Test Redis value' с ключом 'testRedisKey':" . $br;

        $redis = new Redis();

        try {
            $redis->connect('redis');
            $redis->set('testRedisKey', 'Test Redis value');
            $value = $redis->get('testRedisKey');
            echo $value . $br;
        } catch (RedisException $e) {
            echo $e->getMessage();
        }

        echo "Проверка соединения с memcached:" . $br;
        echo "Добавление в memcached записи с ключом testMemcachedKey:" . $br;

        $memcached = new Memcached;

        $memcached->addServer('memcached', 11211);
        $memcached->set("testMemcachedKey", "Test Memcached value");
        echo $memcached->get("testMemcachedKey") . $br;
        ?>
    </div>
</body>
</html>
