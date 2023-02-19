<?php

require __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors', 1);
/** part2 **/
$memcache = new \Memcached();
$memcache->addServer('repcached2', 11211, 1000);
$key = 'server';

$arServers = $memcache->get($key);

if (!$arServers) {
    $arServers = [];
} else {
    $arServers = json_decode($arServers, true);
}

$arServers[] = $_SERVER['HOSTNAME'];
$arServers = array_unique($arServers);

var_dump($arServers);

$memcache->set($key, json_encode($arServers));


/** part1 **/
if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
    $incomingStr = $_POST['string'];
    $pattern = '(()()()()))((((()()()))(()()()(((()))))))';
    $openCnt = substr_count($pattern, '(');
    $closeCnt = substr_count($pattern, ')');

    try {
        if (empty($incomingStr)) {
            throw new Exception('Строка пустая');
        }

        if ($openCnt != substr_count($incomingStr, '(')) {
            throw new Exception('Количество открытых скобок не верное');
        }

        if ($closeCnt != substr_count($incomingStr, ')')) {
            throw new Exception('Количество закрытых скобок не верное');
        }

        echo "Everything ok";
    } catch (Exception $e) {
        http_response_code(400);
        echo $e->getMessage();
    }
}

