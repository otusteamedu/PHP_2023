<?php
/*session_start();
$_SESSION['t'][$_ENV['SERVER_ADDR']][$_ENV['HOSTNAME']]++;
echo '<pre>' . print_r([$_ENV['SERVER_ADDR'], $_ENV['HOSTNAME']],
        1) . '</pre>' . __FILE__ . ' # ' . __LINE__;//test_delete
session_write_close();
echo "Привет, Otus!<br>".date("Y-m-d H:i:s")."<br><br>";
echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];
echo '<pre>' . print_r($_SESSION,1) . '</pre>' . __FILE__ . ' # ' . __LINE__;//test_delete
echo '<pre>' . print_r([
        'nginx' => $_SERVER['NGINX_NUM'] ?? getenv('NGINX_NUM') ?? 'unknown',
        'php' => $_SERVER['APP_NUM'] ?:  getenv('APP_NUM') ?: 'unknown'
    ],1) . '</pre>' . __FILE__ . ' # ' . __LINE__;//test_delete



try {
    $memcached = new Memcached();
    $memcached->addServer('memcached', 11211);
    $memcached->set("testMemcachedKey", "Test Memcached value time = " . time());
    echo print($memcached->get("testMemcachedKey") . PHP_EOL);
} catch (Throwable $e) {
    echo print("Error test memcached: " . $e->getMessage());
}*/

include "vendor/autoload.php";

$app = new \IilyukDmitryi\App\App();
$app->run();
