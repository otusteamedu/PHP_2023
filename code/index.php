<?php

echo "Привет, Anton!<br>".date("Y-m-d H:i:s") ."<br><br>";

if (!class_exists("Memcache"))  exit("Memcached не установлен");
$memcache = new Memcache;
$memcache->connect('localhost', 11211) or exit("Невозможно подключиться к серверу Memcached");
 
$version = $memcache->getVersion();
echo "Server's version: ".$version."<br/>\n";
 
$tmp_object = new stdClass;
$tmp_object->str_attr = 'test';
$tmp_object->int_attr = 123;
 
$memcache->set('key', $tmp_object, false, 10) or die ("Не получилось оставить запись в Memcached");
echo "Записываем данные в кеш Memcached (данные будут храниться 10 секунд)<br/>\n";
 
$get_result = $memcache->get('key');
echo "Данные, записанные в Memcached:<br/>\n";
 
var_dump($get_result);