<p>Привет! Я соединился через unix-сокет.</p>
<p>Проверка подключения к сервисам: </p>
<p>1. Подключение к MySQL<br>
    <?php
    try {
        $pdo = new PDO(
            'mysql:host=mysql',
            'root',
            'root'
        );
        echo '<span style="color:green;">Соединение с базой данных: успешно</span><br>';
    } catch (PDOException $e) {
        $error = $e->getMessage();
        echo '<span style="color:green;">' . $error . '</span><br>';
    }
    ?>
</p>

<p>2. Подключение к Redis<br>
    <?php
    $redis = new Redis();
    try {
        $redis->connect('redis', 6379);
        echo "<span style = 'color:green'>Соединение с Redis: успешно</span><br>";
    } catch (Exception $e) {
        $error = $e->getMessage();
        echo "<span style = 'color:red'>{$error}</span><br>";
    }
    ?>
</p>

<p>3. Подключение к Memcached<br>
    <?php
    try {
        $memcached = new Memcached();
        $memcached->addServer("memcached", 11211);
        $response = $memcached->get("successful");
        if (!$response) {
            $memcached->set("successful", "Memcached работает");
            $response = $memcached->get("successful");
        }
        echo "<span style = 'color:green'>{$response}</span><br>";
    } catch (Exception $e) {
        $error = $e->getMessage();
        echo "<span style = 'color:red'>{$error}</span><br>";
    }
    ?>
</p>

<?php
phpinfo();
