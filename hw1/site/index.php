<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Заголовок HTML</title>
</head>
<body>
    <h1>Заголовок HTML 123</h1>
    <?php
    include($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

    echo '<p><b>Данные из $_ENV:</b> ' . $_ENV['MYSQL_USER'] . '</p>';

    // Create a new instance of Memcached
    $memcached = new Memcached();
    $memcached->addServer('memcached', 11211);
    $memcached->set('my_key', 'My Value Memcached');
    $value = $memcached->get('my_key');
    echo "<p><b>Значение из Memcached:</b> " . $value . "</p>";
    $memcached->delete('my_key');
    $memcached->quit();

    $redis = new Redis();
    $redis->connect('redis', 6379);
    $redis->set('my_key', 'Hello Redis!');
    $value = $redis->get('my_key');
    echo "<p><b>Значение из Redis:</b> " . $value . '</p>';
    $redis->close();

    $dsn = "mysql:host=mariadb;dbname=".$_ENV['MYSQL_DATABASE'].";charset=utf8mb4";
    $pdo = new PDO($dsn, $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Создание таблицы
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL
    )");

    // Вставка данных в таблицу
    /*$stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
    $stmt->execute(["John Doe", "john@example.com"]);
    $stmt->execute(["Jane Smith", "jane@example.com"]);
    echo "Таблица создана и данные вставлены";*/

    // Создание таблицы
    echo '<b>Данные из таблицы users:</b><br>';
    $res = $pdo->query("SELECT * FROM users");
    while($ar = $res->fetch()) {
        var_dump($ar);
    }

    phpinfo();
    ?>
</body>
</html>
