<?php

echo "Привет, Anton!<br>".date("Y-m-d H:i:s") ."<br><br>";

if (!class_exists("Memcached"))  exit("Memcached не установлен");
$memcached = new Memcached;
$memcached->addServer('192.168.56.56', 11211) or exit("Невозможно подключиться к серверу Memcached");

$version = $memcached->getVersion();
echo "Server's version: <br/>\n";
print_r($version);
echo "<br/>\n"; 
$tmp_object = new stdClass;
$tmp_object->str_attr = 'test';
$tmp_object->int_attr = 123;
 
$memcached->set('key', $tmp_object, 10) or die ("Не получилось оставить запись в Memcached");
echo "Записываем данные в кеш Memcached (данные будут храниться 10 секунд)<br/>\n";
 
$get_result = $memcached->get('key');
echo "Данные, записанные в Memcached:<br/>\n";
 
var_dump($get_result);