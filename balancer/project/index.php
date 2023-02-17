<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>HomeWork 5</title>
    </head>
    <body>
        <div>
        <?php
        $br = '<br>';
        echo "Привет, Otus!" . $br . date("Y-m-d H:i:s") . $br . $br;
        echo "Запрос обработал контейнер app: " . $_SERVER['HOSTNAME'] . $br;
        echo $br;
        echo "Запрос обработал контейнер nginx: " . $_SERVER['SERVER_NAME'] . $br;
        echo $br;
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
                echo($row["table_name"] . '-' . $row["column_name"] . $br);
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        echo $br;
        echo "Проверка хранения сессий в memcached:" . $br;
        echo 'В начале страницы стартует сессия session_start(), PHPSESSID корректно записывается в куки' . $br;
        echo 'Статус сессии: ' . session_status() . $br;
        echo 'Путь сохранения сессии: ' . session_save_path() . $br;
        ?>
        </div>
    </body>
</html>
