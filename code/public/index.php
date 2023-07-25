<?php

use VKorabelnikov\Hw13\DataMapper\FilmColumnsMapper;

// echo "Hello!";

// $dbconn3 = pg_connect("host=hw13-postgres port=5432 dbname=test user=test password=test");
// var_dump(pg_version($dbconn3));


$pdo = new \PDO("pgsql:host=hw13-postgres;port=5432;dbname=test;","test", "test");

var_dump($pdo);

$selectPdoStatement = $pdo->prepare(
    "SELECT name, duration, cost FROM test WHERE id = :id"
);


$selectPdoStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $selectPdoStatement->execute(['id' => 2]);
        $filmParams = $selectPdoStatement->fetch();

var_dump($filmParams);

// phpinfo();
