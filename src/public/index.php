<?php

require_once __DIR__ . "/../vendor/autoload.php";
//echo phpinfo();


$serverName = "mysql";
$userName = "root";
$password = "secret";
$port = "3306";
$dbName = "myDB";
try {
  $conn = new PDO("mysql:host=$serverName;port=$port;dbname=$dbName", $userName, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo 'Mysql connected successfully <br />';
} catch(PDOException $e) {
  echo "Mysql connection failed: " . $e->getMessage() . "<br />";
}



$mc = new Memcached();
$mc->addServer("memcached", 11211);

if ($addMC = $mc->add("test", "success")) {
    echo "Memcached connect successfully <br />";
    $mc->delete("test");
}else{
    echo "Memcached connection failed <br />";
}

