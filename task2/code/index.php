<?php

phpinfo();

echo "Привет, Otus!<br>".date("Y-m-d H:i:s")."<br><br>";

echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME']."<br><br>";

$memcached = new Memcached();
$memcached->addServer("memcached", 11211);

//var_dump($memcached); exit;

$response = $memcached->get("Bilbo");
if ($response) {
    echo $response."<br><br>";
} else {
    echo "Adding Keys (K) for Values (V), You can then grab Value (V) for your Key (K) \m/ (-_-) \m/ "."<br><br>";
    $memcached->set("Bilbo", "Here s Your (Ring) Master stored in MemCached (^_^)") or die(" Keys Couldn't be Created : Bilbo Not Found :'( ")."<br><br>";
}
