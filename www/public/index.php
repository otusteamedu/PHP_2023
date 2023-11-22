<?php

declare(strict_types=1);

session_start();
if (empty($_SESSION['temp'])) {
    $_SESSION['temp'] = rand(1000, 9999);
}

if (isset($_POST['string'])) {
    require_once __DIR__ . '/src/StringValidator.php';

    try {
        \src\StringValidator::validate($_POST['string']);
        echo 'String is correct!';
    } catch (InvalidArgumentException $error) {
        http_response_code(400);
        echo $error->getMessage();
    }
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
 <title>Test</title>
</head>
<body>
    Nginx Instance IP ($_SERVER['SERVER_ADDR']): <b><?php echo $_SERVER['SERVER_ADDR']; ?></b>
    <br />
    PHP-FPM HostName ($_SERVER['HOSTNAME']): <b><?php echo $_SERVER['HOSTNAME']; ?></b>
    <br />
    Session Value: <b><?php echo $_SESSION['temp']; ?></b>
    <br />
    <hr />
    <?php
    // Test MySQL
    $db = mysqli_connect('mysql', 'root', 'root', 'mysql');
    $res = mysqli_query($db, "SHOW TABLES");
    if ($res !== false && mysqli_num_rows($res) > 0) {
        echo 'MySQL OK.';
    } else {
        echo 'MySQL ERROR.';
    }
    mysqli_close($db);
    ?>
    <br />
    <?php
    // Test memcached
    $memcached = new Memcached();
    $memcached->addServer('memcached', 11211);
    $memcached->add('memcached_key', 'test');
    echo $memcached->get('memcached_key') ? 'Memcached OK.' : 'Memcached ERROR.';
    ?>
    <hr />
    <h3>Validate string</h3>
    <form action="" method="post">
        <label for="string"></label>
        <input type="text" name="string" id="string" value="" placeholder="Input string" />
        <button type="submit">Validate</button>
    </form>
</body>
</html>
