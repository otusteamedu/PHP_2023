<?php

$m = new Memcached();
$m->addServer('memcached', 11211);
$m->set('greeting', "Привет, Otus!");
$greeting = $m->get('greeting');

echo $greeting;
echo "<br>Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];
